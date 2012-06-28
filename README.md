hamradio-logbook
================

Ultra simple ham radio logbook

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

4 - Copy all the files to you Apache document root or wherever you've configured your webserver

5 - Configure config.php files according to your needs.
 
