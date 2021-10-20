FROM tomsik68/xampp:7


EXPOSE 80
EXPOSE 8000

ENV DEBIAN_FRONTEND=noninteractive
ENV DB_DATABASE=phx
ENV DB_USERNAME=root
ENV DB_PASSWORD=root
ENV PATH=/opt/lampp/bin/:$PATH
ENV PORT=80

# VOLUME mysql /opt/lampp/var/mysql

COPY docker_config.sh /
RUN bash /docker_config.sh

RUN rm -rf /opt/lampp/htdocs/
COPY . /opt/lampp/htdocs/
WORKDIR /opt/lampp/htdocs/
RUN chmod 777 -R /opt/lampp/htdocs/

# Composer Install
RUN composer install
RUN chmod 777 -R /opt/lampp/

CMD /opt/lampp/lampp startmysql && \
    sleep 10 && \
    /opt/lampp/bin/mysqladmin create phx && \
    /opt/lampp/bin/mysqladmin create phx_test && \
    /opt/lampp/bin/mysql -uroot -e "ALTER USER 'root'@'localhost' IDENTIFIED BY 'root';"  && \
    /opt/lampp/bin/mysql -uroot -proot -e "FLUSH PRIVILEGES;" && \
    php artisan migrate:fresh --force && \
    php artisan db:seed && \
    sed -i "s|Listen 80|Listen $PORT|" /opt/lampp/etc/httpd.conf && \
    sed -i "s|VirtualHost \*:80|VirtualHost \*:$PORT|" /opt/lampp/etc/extra/httpd-vhosts.conf && \
    bash /startup.sh
