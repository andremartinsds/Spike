<p align="center"><img src="./public/images/readme/spike.svg" width="400"></p>

## Como instalar

> atenção é preciso ter o composer instalado

```
git clone git@github.com:AndreMart/cart-laravel.git

```

```
php artisan install

```

```
php artisan key:generate
```

### Crie sua base de dados

### copie e cole o arquivo .env.example para .env

### atribua os valores pertinentes

```
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=SUA PORTA GERALMENTE 3306
DB_DATABASE=SUA BASE DE DADOS
DB_USERNAME=USUARIO
DB_PASSWORD=SENHA
```
### após isso rode os seguintes comandos separadamente
```
php artisan migrate

php artisan db:seed

```
### note que os dados de entrada no sistema estão registrados no arquivo /databases/seeds/UserTableSeeder

<p>by: André Martins</p>
