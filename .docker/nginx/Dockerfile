FROM nginx:alpine
WORKDIR /var/www/html

COPY ./.docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY backend/public /var/www/html/public/
