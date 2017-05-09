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
sudo apt-get install php5 libapache2-mod-php5 php5-mcrypt

Edit dir.conf to to request PHP first:
sudo nano /etc/apache2/mods-enabled/dir.conf
<IfModule mod_dir.c>
    DirectoryIndex index.php index.html index.cgi index.pl index.xhtml index.htm
</IfModule>

sudo service apache2 restart

Install PHP modules as required.

2.	Copy All files to the webserver directory. 

3.	Properly configure server:

Edit /etc/sysctl.d/10-network-security.conf to this:
 
Ignore ICMP broadcast requests
net.ipv4.icmp_echo_ignore_broadcasts = 1
 
Disable source packet routing
net.ipv4.conf.all.accept_source_route = 0
net.ipv6.conf.all.accept_source_route = 0
net.ipv4.conf.default.accept_source_route = 0
net.ipv6.conf.default.accept_source_route = 0

Ignore send redirects
net.ipv4.conf.all.send_redirects = 0
net.ipv4.conf.default.send_redirects = 0
 
Block SYN attacks
net.ipv4.tcp_max_syn_backlog = 2048
net.ipv4.tcp_synack_retries = 2
net.ipv4.tcp_syn_retries = 5
 
Log Martians
net.ipv4.conf.all.log_martians = 1
net.ipv4.icmp_ignore_bogus_error_responses = 1
 
Ignore ICMP redirects
net.ipv4.conf.all.accept_redirects = 0
net.ipv6.conf.all.accept_redirects = 0
net.ipv4.conf.default.accept_redirects = 0
net.ipv6.conf.default.accept_redirects = 0
 
Ignore Directed pings
net.ipv4.icmp_echo_ignore_all = 1
Load the new rules:
service procps start
Edit /etc/php5/apache2/php.ini to include:
exec, system, shell_exec, and passthru to disable_functions
Change expose_php to Off
Ensure that display_errors, track_errors and html_errors are set to Off
 
Edit /etc/apache2/conf-enabled/security.conf to include:

ServerTokens Prod
ServerSignature Off
TraceEnable Off
Header unset ETag
FileETag None

To take effect enable mod_headers:
ln -s /etc/apache2/mods-available/headers.load /etc/apache2/mods-enabled/headers.load

service apache2 restart



4.	Create the MySQL Database:

create database easypass;

create table user (id int(11) NOT NULL AUTO_INCREMENT, email varchar(111) NOT NULL, password varchar(111) NOT NULL, q1 text DEFAULT NULL, q1a varchar(111) DEFAULT NULL, q2 text DEFAULT NULL, q2a varchar(111) DEFAULT NULL, q3 text DEFAULT NULL, q3a varchar(111) DEFAULT NULL, created_at datetime DEFAULT CURRENT_TIMESTAMP, updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY (id));

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

