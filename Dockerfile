
# Dockerfile for render.com

FROM richarvey/nginx-php-fpm:1.7.2

COPY . .

ENV WEBROOT /var/www/html/public

CMD ["/start.sh"]

