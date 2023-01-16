## Blogging Platform

A customer approached us to build a web blogging platform according with the request.

## Prerequisite

In order to run the app on our local machines, we will need to have [Docker](https://docs.docker.com/) installed.

### Docker

Please visit [Docker page](https://www.docker.com/products/docker-desktop/) and `Download Docker Desktop` according with your OS (Operating System).

## Setup the project

Once we have installed `Docker`, we can proceed with the setup in order to run the project on our local machine.

### Clone the project

Please open your terminal and type:

```bash
git clone https://github.com/alexandrubb23/blogging-platform.git
```

_Note: Please make sure you have git installed._

Once we have cloned the project, we will need to navigate into the newly created project folder:

```bash
cd blogging-platform
```

### Install dependencies

You may install the application's dependencies by navigating to the application's directory and executing the following command. This command uses a small Docker container containing PHP and Composer to install the application's dependencies:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

Please be patience and play a Pac-Man game while the instalation is running...

## Run the project

Given that this project was builded with [Laravel Sail](https://laravel.com/docs/9.x/sail#introduction) we can use the `sail` command line interface

### Creating the environment variables

In order to instruct our app about environment variables, please type in your terminal the following command:

```bash
cp .env.example .env
```

### Configuring A Shell Alias

By default, Sail commands are invoked using the `vendor/bin/sail` script that is included with all new Laravel applications:

```bash
./vendor/bin/sail up
```

However, instead of repeatedly typing vendor/bin/sail to execute Sail commands, you may wish to configure a shell alias that allows you to execute Sail's commands more easily:

```bash
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

Note: To make sure this is always available, you may add this to your shell configuration file in your home directory, such as `~/.zshrc` or `~/.bashrc`, and then restart your shell.

Once the shell alias has been configured, you may execute Sail commands by simply typing sail. The remainder of this documentation's examples will assume that you have configured this alias:

```
sail up
```

### Running Vite

This small app is using [Breeze](https://github.com/laravel/breeze) for authentication features, including login, registration, password reset, email verification, and password confirmation. In addition, Breeze includes a simple "profile" page where the user may update their name, email address, and password. Also, users can create new posts.

```bash
npm i
npm run dev
```

_Note: Please make sure you have npm installed._
_P.S A small Docker container could be created in order to automate this._

### Database migrations

Migrations are like version control for our database, allowing our team to define and share the application's database schema definition

To run all of ours outstanding `migrations`, execute the migrate Artisan command:

```bash
sail artisan migrate
```

For more details, please visit [Database: Migrations](https://laravel.com/docs/9.x/migrations)

Once the migration is finished, we can open our [project](http://localhost) in our favorite browser.

### Seed database with dummy data

Given that this is a dummy APP, we will also need to have our tables populated with some dummy data:

```bash
sail artisan db:seed
```

or

```bash
sail artisan migrate:refresh --seed
```

### Auto import posts from an external resource

Our APP can deal with data from external resources (just one for this assignment) by auto-importing articles from third party API's

```bash
sail artisan schedule:work
```

By default this schedule will run at every minute and try to execute `commands` if they are defined. In our case we have a command called `posts:import` which will import articles from an external API at every hour.

## Testing our APP

Our APP is (or will) covered with tests. In order to run automated tests, please type in your terminal the following command:

```bash
sail artisan test
```

## Troubleshooting

In case you encounter a `Connection refused` error from the app, first check the `.env` file to ensure that the `DB_PASSWORD` is set. If the password is set, the error may be caused by the `DB_HOST` not matching the IP exposed by the Docker container. To find the correct IP, run the command `docker network inspect bridge --format "{{(index .IPAM.Config 0).Gateway}}"` in the terminal, and update the `.env` file with the output IP as the `DB_HOST`.

## Wishes (real world)

I wish I had more time in order to bring this APP to the next level. Please bear with me: it is just a dummy APP.

### User roles

User roles can be also implemented.

-   Admins can review and approve posts.
-   Admin can edit or delete post(s)
-   Admins can add external resources for some certain users..
-   And more...

### Organise views

I would love to have more time in order to organize a bit better the views: layouts; components; etc.

## In a Real World scenario

So far the objective of this assignment is to give you an idea of how I interpret a brief, approach a problem and structure an application. In a real world scenario I won't never used Laravel Blade template. I would like to use a FE library such as: React; Vue or Angular (if the case) instead.

For the backend part, I would like to use Node ([Strapi CMS](https://strapi.io/), [Express](https://expressjs.com/) or [NestJS](https://nestjs.com/)) for building an API and, maybe [Laravel](https://laravel.com/) or [Symfony](https://symfony.com/).

And last but not least, I would like to structure this app using Microservices Architecture and deploy them using [Kubernetes](https://kubernetes.io/).

That being said,

See you on the other side.

Thank you!
