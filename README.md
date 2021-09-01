# PHP Login Register Search App

Written as a part of application for Quantox backend developer position

For this project you will need Composer https://getcomposer.org/

Next you need to run following: 

```bash
composer install
```

Then you need to rename .env.example to .env and enter your DB credentials.

```bash
cp .env.example .env
```

For migrations, we are using robmorgan/phinx.

To create phinx.php config file run:

```bash
vendor/bin/phinx init
```

In phinx.php under development environments add you DB credentials.

Next you need to run following command to migrate DB:

```bash
php vendor/bin/phinx migrate
```

And run:

```bash
php -S 127.0.0.1:8000
```

Now in your browser you can run the 127.0.0.1:8000 url and start the app.