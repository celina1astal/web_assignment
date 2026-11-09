# Use an official PHP runtime with an Apache web server built-in
FROM php:8.2-apache

# Set the proper working directory inside the container
WORKDIR /var/www/html

# Copy all repository files (including index.php) into the server container
COPY . .

# Expose port 80 for web traffic
EXPOSE 80

# Keep the server running dynamically in the foreground
CMD ["apache2-foreground"]
