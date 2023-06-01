
# Dockerfile for render.com

FROM richarvey/nginx-php-fpm:latest

COPY . .

ENV WEBROOT /var/www/html/public

CMD ["/start.sh"]

