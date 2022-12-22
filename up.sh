 #!/bin/bash
# Create a type alias called sail
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'

# Run the Database Migrations
sail artisan migrate

# Run the APP
sail up