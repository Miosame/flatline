# flatline
simple, beautiful & fully-responsive local network monitoring

![image](https://user-images.githubusercontent.com/8201077/72768359-71c63f00-3bf7-11ea-8a1f-0ca02bb6909a.png)

# requirements 

1. docker & docker-compose: https://www.digitalocean.com/community/tutorials/how-to-install-docker-compose-on-ubuntu-18-04

# variables explained

This section explains the variables that are of interest inside `.env`

- `SCAN_INTERVAL` = how often a local network scan should happen, value in seconds (300 by default)
- `SCAN_RANGE` = the network range that should be scanned, possible formats are:
  - `"192.168.0.2-192.168.0.254"`
  - `"192.168.1.134/29"`
- `DB_PORT_CUSTOM` = if you have another mysql database listening on port :3306, then for now you want to change it here to another port, more details: [#7](https://github.com/Miosame/flatline/issues/7) - in the future that might not be necessary.

# instructions

1. `git clone --depth=1 https://github.com/Miosame/flatline.git`
2. make sure you are in the new directory `cd flatline/`
3. change all values marked as `XXX` inside `.env`
4. `chmod +x ./install.sh && ./install.sh`
5. wait for it to finish and it'll by default expose to `http://localhost`
6. now depending on what value you've set for `SCAN_INTERVAL` - wait for one rotation of that interval and shortly after all your local devices should show up in the dashboard

# notes

You can see actively planned / confirmed TODOs in [projects](https://github.com/Miosame/flatline/projects), if it isn't listed, please feel free to open a new issue describing your idea and if it fits the project, I will add it in.

If you want to contribute, know that this project is based on:
- [laravel](https://laravel.com/)
- scss (with [koala](http://koala-app.com/) - [config](https://github.com/Miosame/flatline/blob/master/php-mysql-image/html/resources/sass/koala-config.json) already included)
- [tailwind](https://tailwindcss.com/)
