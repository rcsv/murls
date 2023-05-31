
# Dockerfile for Render.com
# creation date: 2023-05-31

FROM debian:latest

# Set the working directory in the container
WORKDIR /var/www/html

# Update the system
RUN apt-get update && apt-get upgrade -y

# Install nginx, PHP 8.2 and MariaDB
RUN apt-get install -y nginx
RUN apt-get install -y software-properties-common lsb-release apt-transport-https ca-certificates 
RUN wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
RUN echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/php.list
RUN apt-get update
RUN apt-get install -y php8.2-fpm php8.2-mysql
RUN apt-get install -y mariadb-server

# Copy the default nginx config
COPY nginx.conf /etc/nginx/sites-available/default

# Expose web and db port
EXPOSE 80 443 3306

# Start the services
CMD service nginx start && service php8.2-fpm start && service mysql start && /bin/bash
