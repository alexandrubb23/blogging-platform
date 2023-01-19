 #!/bin/bash

# This bash script is for lazy persons 😀 ¯\_(ツ)_/¯

# This command uses a small Docker container containing PHP and Composer to install the application's dependencies 🚢
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs;

# Create a type alias called sail
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'

# Run the APP (in detach mode) ) 🚀
sail up -d

# Run the Database Migration + seed 🛢
sail artisan migrate:refresh --seed

# Start auto importing 👷
sail artisan schedule:work