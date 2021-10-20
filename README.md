# Teste PHX
Teste PHX

# Requisitos
* [PHP>=7.4.24](https://www.php.net/downloads.php)
* [Composer=>2.0.14](https://getcomposer.org/download/)
* [MySql=>5,7](https://www.mysql.com/downloads/)
* [Docker](https://docs.docker.com/get-docker/) (Opcional)

# Setup
```sh
git clone https://github.com/stdioh321/teste-phx.git
cd teste-phx

# Instalar as dependencias do laravel
composer install

# Configurar o mysql
# Criar o banco de dados da aplicaçao e o de testes
mysqladmin create phx
mysqladmin create phx_test

# Trocar a senha do usuario root
mysql -uroot -e "ALTER USER 'root'@'localhost' IDENTIFIED BY 'root';"  
mysql -uroot -proot -e "FLUSH PRIVILEGES;"
```

# Rodar
```sh
php artisan serve
```
A aplicacao deve rodar na url: **http://localhost:8000**


# Referencias
* https://github.com/lucascudo/laravel-pt-BR-localization
* https://seucarro.net/marcas-e-modelos-de-automoveis/
* https://developpaper.com/using-swagger-in-laravel-5-6/