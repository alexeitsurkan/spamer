FROM yiisoftware/yii2-php:7.3-apache

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN apt-get update && apt-get install -y \
    cron \
    rsyslog \
    vim \
    unzip

RUN apt update && apt install -y \
    nodejs \
    npm

#переустанавливаем xdebug`ер
RUN pecl uninstall xdebug
RUN pecl install xdebug-2.9.5
RUN docker-php-ext-enable xdebug

RUN install-php-extensions calendar zip

#устанавливаем компосер
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

COPY docker-entrypoint.sh /usr/local/bin
COPY app-cron /etc/cron.d/app-cron

# Give execution rights on the cron job
RUN chmod 0644 /etc/cron.d/app-cron

# Apply cron job
RUN crontab /etc/cron.d/app-cron

ENTRYPOINT ["sh","/usr/local/bin/docker-entrypoint.sh"]

#запускаем процесс apache2
CMD cron && service rsyslog start && /usr/sbin/apache2ctl -D FOREGROUND