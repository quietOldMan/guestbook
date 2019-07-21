Updating database schema after v0.2
-----------------------------------
In v0.2 there is changes in entities. You need to sync the database schema with the current mapping file.

For that run following command after checkout:

    php vendor/bin/doctrine orm:schema-tool:update --force

Set permissionson on _**public**_ folder to _*www-data:www-data*_ (or similar web server user:group depending on your operating system).

    sudo chown -R www-data:www-data ./public
 