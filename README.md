# Hue Control Center

This Hue Control Center gives you the possibility to control your lights. It is simply done by placing the files into a directory which can be accessed from your local network. 

## Requirements

This project has the following requirements:
* A PHP-capable server (PHP 7.4.3 or higher)
* A Philips Hue Bridge in the same local network as the server

## Warnings

The `config.ini` file contains sensible data (after the setup is completed), e.g. the username for connecting to and controlling the bridge. These information are / this file is accessible from your local network or more depending on your configuration. If you do not trust devices in your local network do not use this project or limit the access to the `config.ini` with e.g. 

```
<Files "<path>/config.ini">
    Require all denied
</Files>
``` 
for Apache or

```
location = /config.ini {
    deny all;
    return 404;
}
```
for Nginx. (Please do some research on your own where to place these.)

## Installation

If you are using Nginx, you may follow [this tutorial](https://www.digitalocean.com/community/tutorials/how-to-install-linux-nginx-mysql-php-lemp-stack-on-ubuntu-20-04#step-3-%E2%80%93-installing-php).

If you are using Apache, you may follow [this tutorial](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-20-04#step-3-%E2%80%94-installing-php).

Otherwise, you can just place these files under your web-accessible directory and make them read- and writeable to and from your webserver.

### First Start

When accessing the index.php for the first time, it automatically redirects (temporarily) to the setup, where you can insert the IP address of your bridge. If you do not have access to its IP address, you can search for it using the setup, which may take a long time.

The setup should be self-explanatory.

## Use

Currently, you can turn on, off the lights registered to your bridge. Additionally, you can change the hue, saturation and brightness of your lights, if they are capable of that. 