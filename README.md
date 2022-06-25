# Mailer lite coding test
# Requirements
To run the project, you will need the tools:
- PHP 8.1, with all the extension to run the Laravel Framework 
- Composer
- Node runtime

# Run the project
- Run `composer install` to install all the dependencies
- Run `npm i` to install all node modules
- Run `npm run prod` to compile the assets
- Copy the .env.example to .env, and adjust the configurations
- Run `php artisan key:generate`
- Run `php artisan serve`
- You can access the website on "https://localhost:8000"

# Run the test
to run the test you will need the PHP SQlite Extension
if you are on a debian based system, you can run `apt install php8.1-sqlite`(supposing you already php8.1 installed)

To run the test run the command:
`php artisan test`

if you want to run the test against a real database, you can comment the `DB_CONNECTION` line in the `phpunit.xml` file