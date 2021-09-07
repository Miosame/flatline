const mysql = require("mysql2");
const {getIPRange} = require('get-ip-range');
const Ping = require('ping-lite');
const find = require('local-devices');
const os = require('os');
const localmacaddress = require('getmac').default;
const dns = require('dns');

// in case there's quotes passed as env
function cleanENV(input){
	return input.replace(/(^")|("$)/g, '');
}

// mysql
const connection = mysql.createConnection({
	host: "127.0.0.1",
	port: cleanENV(process.env.DB_PORT) || 3306,
	user: cleanENV(process.env.MYSQL_USER) || "root",
	password: cleanENV(process.env.MYSQL_PASSWORD) || "XXX",
	database: cleanENV(process.env.MYSQL_DATABASE) || "flatline"
});

const ipRange = cleanENV(process.env.SCAN_RANGE) || "192.168.0.2-192.168.0.254";
const ipv4CIDR = getIPRange(ipRange);
const scan_interval = process.env.SCAN_INTERVAL || 50;

function error(err) {
	console.log(err);
}

function scanNetwork() {
	return new Promise(async (resolve, reject) => {
		let hosts = [];
		await Promise.all(ipv4CIDR.map(async (hostIP) => {	
			let alive = await isAlive(hostIP);

			if(alive) {
				let device = await getMACHostname(hostIP);
				if(device) {
					let hostname = device.name;
					// check to see if we have the hostname available from the other scan
					if(hostname === "?" && process.env.SCAN_DNS_SERVER !== "") {
						dns.setServers([ process.env.SCAN_DNS_SERVER ]);
						try {
							await dns.promises.reverse(hostIP).then((hostnames) => {
								hostname = hostnames.join(", ")
							})
						} catch (error) {
							hostname = null;
						}
					}

					hosts.push({
						hostname: ((hostname === "?") ? null : hostname),
						ipaddr4: device.ip,
						macaddr: device.mac
					});
				}else{
					// local machine, resolve manually
					hosts.push({
						hostname: ((!os.hostname()) ? null : os.hostname()),
						ipaddr4: hostIP,
						macaddr: localmacaddress()
					});
				}
			}
		}));

		resolve(hosts);
	}).catch(error);
}

async function getMACHostname(hostIP) {
	return new Promise((resolve) => {
		find(hostIP).then(device => {
			resolve(device);
		}).catch(() => resolve(false));
	}).catch(error);
}

async function isAlive(hostIP) {
	return new Promise(async (resolve) => {
		let ping = new Ping(hostIP);

		ping.send((err, ms) => {
			resolve(!err && !!ms);
		});

		setTimeout(() => {
			ping.stop();
			resolve(false);
		}, 5000);
	}).catch(error);
}

async function saveNodes(nodes) {
	// if it doesn't exist, create it
	// if it already exists, then update it to be "online"
	for(let index in nodes) {
		let node = nodes[index];
		await new Promise((resolve,reject) => {
			connection.query(
				"INSERT INTO `nodes`(hostname, ipaddr4, macaddr) VALUES(?,?,?) ON DUPLICATE KEY UPDATE online=true,ipaddr4=?",
				[node.hostname, node.ipaddr4, node.macaddr, node.ipaddr4],
				function (err, results) {
					if (err) reject(err);
					resolve(results);
				}
			);
		}).catch(error);
	}

	// select all nodes and run through them
	// increment their offline counter if still unpingable
	// in the future remove a node if it is offline?
	// or just have GUI option to delete, a delete node button

	connection.query("SELECT * FROM `nodes`", async (err,results) => {
		for(let index in results) {
			let node = results[index];

			await new Promise(async (resolve,reject) => {
				let alive = await isAlive(node.ipaddr4);
				let offlineCount = ((alive) ? node["offline-count"] : ++node["offline-count"]);
				connection.query(
					"UPDATE `nodes` SET online=?,`offline-count`=? WHERE macaddr=?",
					[alive, offlineCount, node.macaddr],
					function (err, results) {
						if (err) reject(err);
						resolve(results);
					}
				);
			}).catch(error);
		}
	});
}

setInterval(async () => {
	await (async () => {
		let networkNodes = await scanNetwork();
		await saveNodes(networkNodes);
	})().catch(error);
}, scan_interval * 1000);