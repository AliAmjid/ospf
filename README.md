MyOSPF
=================

Made by Ali Amjid

Used technology
------------
 - Nette
 - Gulp
 - NPM
 - Composer
 - cytoscape.js

Requirements
------------

PHP 5.6 or higher.


Installation
------------
Clone repository to your machine 
configure the server (U can use WAMP or XAMPP on windows) . Root dir shoud be `/www`)

Insert the database to database (in root folder database.sql)

run this commands 

 - `cd /file/myospf/`
 - `composer install`
 - `npm install`
 - `gulp`
 
 Set database access in `app/config/config.local.neon`

Make directories `temp/` and `log/` writable.

