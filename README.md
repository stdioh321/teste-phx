# Teste PHX
Teste PHX.
Instruções de execução deste teste: **[instruções](./docs/etapa_final.txt)**

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

# Trocar a senha do usuario root para ser a mesma do .env e .env.testing
mysql -uroot -e "ALTER USER 'root'@'localhost' IDENTIFIED BY 'root';"  
mysql -uroot -proot -e "FLUSH PRIVILEGES;"


# Efetuar as migrations e seeders.
php artisan migrate
php artisan db:seed
```
|migrate/see|
|:--|
|![migrate/seed](./docs/screenshoot_08.png)|


# Como rodar
```sh
php artisan serve
```
A aplicação deve rodar na url: **http://localhost:8000/carros**
|/carros [GET]|/carros/{id} [GET]|/carros/{id} [GET] id incorreto|
|:--|:--|:--|
|![carros](./docs/screenshoot_01.png)|![carros](./docs/screenshoot_02.png)|![carros](./docs/screenshoot_09.png)

|/carros [POST]|/carros [POST] json incorreto|
|:--|:--|
|![carros](./docs/screenshoot_03.png)|![carros](./docs/screenshoot_04.png)

|/carros/{id} [PUT]|/carros/{id} [PUT] json incorreto|
|:--|:--|
|![carros](./docs/screenshoot_05.png)|![carros](./docs/screenshoot_10.png)

|/carros/{id} [DELETE]|/carros/{id} [DELETE] id incorreto|
|:--|:--|
|![carros](./docs/screenshoot_06.png)|![carros](./docs/screenshoot_11.png)

# Testes
A aplicação possui alguns testes com phpunit.

```sh
./vendor/bin/phpunit
```
|Teste|
|:---|
|![carros](./docs/screenshoot_07.png)|

# Rodar com Docker
```sh
# Criar a imagem que possui o laravel e mysql utilizando o Dockerfile
docker build -t teste-phx .

# Rodar o container na porta 8001
docker run -p8001:80 -it teste-phx
```
Abra no navegador: **http://localhost:8001/carros**


|Terminal|Browser|
|:---|:---|
|![terminal](docs/screenshoot_12.png)|![browser](docs/screenshoot_13.png)

# Referencias
* https://github.com/lucascudo/laravel-pt-BR-localization
* https://seucarro.net/marcas-e-modelos-de-automoveis/
* https://developpaper.com/using-swagger-in-laravel-5-6/