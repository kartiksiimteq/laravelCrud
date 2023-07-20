#!/bin/bash

# Prompt the user to enter the number of times to run the seed command
read -p "Enter the number of times to run the seed command: " n

# Check if the input is a valid positive integer
if ! [[ $n =~ ^[1-9][0-9]*$ ]]; then
  echo "Invalid input. Please enter a valid positive integer."
  exit 1
fi

# Loop 'n' times and execute the 'php artisan db:seed' command
for ((i=1; i<=$n; i++))
do
    php artisan db:seed
done
