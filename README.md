BIG FAT WARNING
===============

I don't maintain this code anymore. It has many security flaws.

I left it here just in case someone finds it useful.

Use it at your own risk.

hamradio-logbook
================

Basic ham radio logbook

For log my contacts, I made my own logbook. 
It's writen in PHP and uses a MySQL database. 
My motivation came since I couldn't find a simple logbook.

Install
-------

1 - Create the database:
    mysql> create database logbook;

2 - Create the tables using the "create_tables" and script under the install directory.

3 - Create and populate the countries table:
    mysql -u[user] -p[password] logbook < install/countries.sql

4 - Grants on MySQL
    grant all on logbook.* to 'michel'@'localhost' identified by 'testpass';

5 - Copy all the files to you Apache document root or wherever you've configured your webserver


6 - Configure config.php files according to your needs.

TODO
- Sanitize user input in SQL queries using something similar to mysqli.real-escape-string
- Fix update on search edit edit.
- A better installer.
- Stats.
- Clean unused stuff.
- Finish the project.

 
