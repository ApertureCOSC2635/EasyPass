# EasyPass
# EasyPass

EasyPass is a University project completed for the Unit COSC2635 at RMIT University. The aim of this project was to plan, develop and deliver a password free secure application for storage of a users credentials.

## Getting Started

Please use the latest version from the master

### Prerequisites

Ubuntu 14.04,  MySQL 5.6 or later, Apache2, PHP

### Installing
1.	Install Lamp Stack in Ubuntu 14.04:

Install apache:
sudo apt-get update
sudo apt-get install apache2

Install MySQL:
sudo apt-get install mysql-server php5-mysql
sudo mysql_install_db
sudo mysql_secure_installation

Install PHP:
sudo apt-get install php5 libapache2-mod-php5 php5-mcrypt php5-curl

Edit dir.conf to to request PHP first:
sudo nano /etc/apache2/mods-enabled/dir.conf
<IfModule mod_dir.c>
    DirectoryIndex index.php index.html index.cgi index.pl index.xhtml index.htm
</IfModule>

sudo service apache2 restart

Install PHP modules as required.

2.	Copy All files to the webserver directory.

4.	Create the MySQL Database:

create database easypass;

5. If you are to time poor to do all of the above (eg RMIT staff) then you can
run it in XAMPP for Windows, following the instructions in XAMPP.txt

## Test that the server is working correctly

Run the application from a web browser to ensure that everything is working correctly.

## Built With

* [Bootstrap]( http://getbootstrap.com/) - Framework
* [CyptoJS]( https://github.com/sytelus/CryptoJS) – Crypto Library

## Authors

Scott
Rhys
Diana
Gerry
Nic

## License
