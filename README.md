# Book Management Web Application

## BackEnd Configuration

1- Clone the repository

    git clone https://github.com/ali-maihoob/maxima.git

2- Switch to the repo folder

    cd maxima

3- Init env File:
On Windows:

    copy .env.example .env
On Linux:

    cp .env.example .env

4- Install all the dependencies using composer

    composer install

## Database Configuration
1- create new database called: maxima


The default database username is "root" and password is empty so if you want to change them, you can update .env file

2- Database Migration

    php artisan migrate

3- Database Seeder

    php artisan db:seed


## FrontEnd Configuration

1- Enter Client folder:

        cd client

2- Install Independence:

        npm install

3- Init env File:
On Windows:

    copy .env.example .env
On Linux:

    cp .env.example .env

and be sure the API_BASE_URL in .env should be same backend url

4- Run the project:

        npm run serve

5- Default configuration:

        admin@admin.com
        123456
