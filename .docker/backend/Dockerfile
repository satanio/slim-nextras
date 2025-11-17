FROM php:8.4-fpm

# composer stuff
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
    	cron \
    	supervisor \
		git \
        iproute2 \
		unzip \
    && rm -rf /var/lib/apt/lists/*

# php extensions installer
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions \
	&& install-php-extensions \
    	amqp \
    	bcmath \
    	calendar \
    	exif \
    	gd \
    	intl \
    	ldap \
    	opcache \
    	pcntl \
    	mysqli \
    	pdo_mysql \
    	soap \
    	xdebug \
        xsl \
    	zip

COPY .docker/backend/php_user_config.dev.ini /usr/local/etc/php/conf.d/php_user_config.ini

# wait for it
ADD https://raw.githubusercontent.com/vishnubob/wait-for-it/master/wait-for-it.sh /usr/local/bin/
RUN chmod +rx /usr/local/bin/wait-for-it.sh

ARG USER=www-data

ENV USER=$USER
ENV HOME=/home/$USER
ENV COMPOSER_HOME=$HOME/.composer

# allow dots in username
RUN sed -i 's/#NAME_REGEX=.*/NAME_REGEX="^[a-z][-a-z0-9_\.]*\$"/' /etc/adduser.conf

RUN if ! id -u $USER > /dev/null 2>&1; then \
	adduser --disabled-password --gecos "" $USER ; fi \
    && mkdir -p $HOME \
    && chown -R $USER:$USER /var/www/html $HOME

COPY .docker/backend/supervisor.conf /etc/supervisor/conf.d/supervisord.conf
RUN chmod u+s /usr/bin/supervisord

USER $USER:$USER

WORKDIR /var/www/html

COPY --chown=$USER backend/composer.* ./
RUN composer install --no-dev --no-autoloader --no-interaction

COPY --chown=$USER backend .
RUN composer dump-autoload --no-interaction

RUN rm -rf $COMPOSER_HOME
