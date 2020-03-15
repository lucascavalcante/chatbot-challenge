# Chatbot Challenge

A chatbot that manages users and accounts. Besides that, it manages exchange currencies.

## Requirements

* Docker/Docker-compose
* Composer
* Nginx, PHP 7.2 and Mysql (managed by Docker)

# Installation

Clone the repository
> `git clone https://github.com/lucascavalcante/chatbot-challenge.git`
or
> `git clone git@github.com:lucascavalcante/chatbot-challenge.git`

Install all dependencies
> `composer install`

Create a `.env` file
> `cp .env.example .env`

Add/replace these configurations on `.env` file

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=default
DB_USERNAME=default
DB_PASSWORD=secret

API_CURRENCY_CONVERSION={api key from https://free.currencyconverterapi.com}
```

Configuring Docker
> `cd laradock`
> `cp env-example .env`
> `docker-compose up nginx php-fpm mysql`
* If nginx conflicts with another port, you can set a new port on line 252 in `.env` file)

(open a new terminal) Back to root folder 
> `cd ..`

Run a composer script that generates the key, runs migrates and runs seeders
> `composer key-migrations-and-seeders`

Author:
* [Lucas Cavalcante](https://lucascavalcante.dev)