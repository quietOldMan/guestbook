Guestbook test project
=================================

Installation
------------
Copy _**config/database.php.dist**_ to _**config/database.php**_. Create new DB and configure database connection in _**config/database.php**_

After configuration of connection run following commands:

    composer install
    php vendor/bin/doctrine orm:schema-tool:create  # create database schema

Fixtures
--------
You can fill database with generated fake data for testing purposes.

**WARNING: There is no check for dev environment, use with caution!**

For more information see:

    php script/load-fixtures.php --help 