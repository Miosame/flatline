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

# instructions

1. `git clone --depth=1 https://github.com/Miosame/flatline.git`
2. change all values marked as `XXX` inside `.env`
3. `cd flatline/ && chmod +x ./install.sh && ./install.sh`
4. wait for it to finish and it'll by default expose to `http://localhost`
5. now depending on what value you've set for `SCAN_INTERVAL` - wait for one rotation of that interval and shortly after all your local devices should show up in the dashboard

# notes

You can see actively planned / confirmed TODOs in [projects](https://github.com/Miosame/flatline/projects), if it isn't listed, please feel free to open a new issue describing your idea and if it fits the project, I will add it in.

If you want to contribute, know that this project is based on:
- [laravel](https://laravel.com/)
- scss (with [koala](http://koala-app.com/) - [config](https://github.com/Miosame/flatline/blob/master/php-mysql-image/html/resources/sass/koala-config.json) already included)
- [tailwind](https://tailwindcss.com/)