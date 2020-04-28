## Instalación 

Ates de la instalación asegurarnos de que tengamos instalado :
- [PHP](https://www.php.net/downloads) 
- [MySQL](https://www.mysql.com/downloads/)
- [Composer](https://getcomposer.org/doc/00-intro.md) 
- [PHPUnit](https://phpunit.readthedocs.io/es/latest/installation.html)
- [NodeJs](https://nodejs.org/es/)

Para el correcto funcionamiento de la app es necesario crear la BD en mysql y correrlo en el puerto por defecto 3306
(mariaDB en su defecto)
```sql
$ mysql -u root -p
$ create database initial_project;
$ grant all on initial_project.* to admin@localhost identified by "admin";
$ grant all on initial_project.* to admin@'%' identified by "admin";
```
Configuracion de entorno .env
```sh
$ cp .env.develop .env
$ php artisan storage:link
```
Para el siguiente comando debes de tener instalado composer [Composer](https://getcomposer.org/doc/00-intro.md), tambien debes de tener habilitada la extensión de soap en el php.ini 
```sh 
$ composer install
```
Realizar las migraciones de la base de datos 
```sh
$ php artisan migrate
$ php artisan db:seed
```
Instalacion de las dependencias de [NodeJs](https://nodejs.org/es/)

```sh
$ npm install
$ npm run dev
```

Ejecutar el servidor y este correrá en el http://localhost:8000/
```sh
$ php artisan serve
```
para realizar las pruebas unitarias
```sh
$ phpunit
```
ó
```sh
$ ./vendor/bin/phpunit.bat 
```