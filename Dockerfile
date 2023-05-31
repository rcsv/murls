
# Dockerfile for Render.com
# creation date: 2023-05-31

FROM richarvey/nginx-php-fpm:latest

ENV WEBROOT=/var/www/html/public

# Set the working directory in the container
WORKDIR /var/www/html

# Update the system
RUN apt-get update && apt-get upgrade -y
