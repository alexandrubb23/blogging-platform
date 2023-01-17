 #!/bin/bash

# This bash script is for lazy persons 😀 ¯\_(ツ)_/¯

# Create a type alias called sail
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'

# Run the APP (in detach mode) ) 🚀
sail up -d

# Run the Database Migration + seed 🛢
sail artisan migrate:refresh --seed

# Start auto importing 👷
sail artisan schedule:work