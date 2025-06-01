# Blog

1 - Clone the repository

2 - Run `cp .env.example .env` file to copy example file to `.env`

Then edit your .env file with DB credentials and other settings.

3 - Run `composer install` command

4 - Run `php artisan migrate --seed` command.

Notice: seed is important, because it will create the first admin user for you.

5 - Run `php artisan key:generate` command.

6 - If you have file/photo fields, run `php artisan storage:link` command.


## Default credentials

`E-mail: admin@admin.com`

`Senha: password`


**Enjoy.**
