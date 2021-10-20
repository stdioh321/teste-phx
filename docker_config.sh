#!/bin/bash

/opt/lampp/bin/php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    /opt/lampp/bin/php -r "if (hash_file('sha384', 'composer-setup.php') === '906a84df04cea2aa72f40b5f787e49f22d4c2f19492ac310e8cba5b96ac8b64115ac402c8cd292b8a03482574915d1a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    /opt/lampp/bin/php composer-setup.php && \
    /opt/lampp/bin/php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer

# /opt/lampp/bin/mysqladmin create fasters && \
#     /opt/lampp/bin/mysql -uroot -e "ALTER USER 'root'@'localhost' IDENTIFIED BY 'root';"  && \
#     /opt/lampp/bin/mysql -uroot -proot -e "FLUSH PRIVILEGES;"

# sed -i "s|apache_server_port=80|apache_server_port=$PORT|" /opt/lampp/properties.ini

sed -i "s|#Include etc/extra/httpd-vhosts.conf|Include etc/extra/httpd-vhosts.conf|" /opt/lampp/etc/httpd.conf
cat > /opt/lampp/etc/extra/httpd-vhosts.conf <<EOF
    <VirtualHost *:80>
        DocumentRoot "/opt/lampp/htdocs/public"
        ServerAdmin *
        <Directory "/opt/lampp/htdocs/">
            Options Indexes FollowSymLinks
            AllowOverride All
            Require all granted
        </Directory>
    </VirtualHost>
EOF
