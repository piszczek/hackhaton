FROM codibly/php:7.1

# INSTALL UTILS
RUN apt-get update && apt-get install -y \
  git \
  htop \
  nano \
  iputils-ping \
  curl \
  cron \
  sqlite \
  gnumeric \
  sudo

#caused some bugs, that can't install psql normally
RUN mkdir -p /usr/share/man/man1 \
    && mkdir -p /usr/share/man/man7 \
    && apt-get install -y --no-install-recommends postgresql-client

# CLEAN APT AND TMP
RUN apt-get clean && apt-get autoremove && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# MKDIR & CHMOD LOG DIR
RUN mkdir /var/log/php-fpm && chmod 766 /var/log/php-fpm

# COPY POOL CONFIGURATION
COPY conf.d/service.conf /usr/local/etc/php-fpm.d

# CREATE PHP.INI FOR CLI AND TWEAK IT
RUN cp /usr/local/etc/php/php.ini /usr/local/etc/php/php-cli.ini && \
  sed -i "s|memory_limit.*|memory_limit = -1|" /usr/local/etc/php/php-cli.ini

# TWEAK MAIN PHP.INI CONFIG FILE
RUN sed -i "s|upload_max_filesize.*|upload_max_filesize = 32M|" /usr/local/etc/php/php.ini && \
    sed -i "s|max_execution_time.*|max_execution_time = 3000|" /usr/local/etc/php/php.ini && \
    sed -i "s|memory_limit.*|memory_limit = 2048M|" /usr/local/etc/php/php.ini

# ALIASES
RUN echo "alias sf='bin/console'" >> ~/.bashrc

WORKDIR /opt/orlen

RUN composer global require codeception/codeception codeception/robo-paracept

RUN printf "\n" | pecl install apcu
RUN docker-php-ext-enable apcu

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]

# Add global functions for turn on/off xdebug
RUN echo "sudo mv /usr/local/etc/php/conf.d/xdebug.ini /usr/local/etc/php/conf.d/xdebug.off && sudo pkill -o -USR2 php-fpm" > /usr/bin/xoff && chmod +x /usr/bin/xoff \
    && echo "sudo mv /usr/local/etc/php/conf.d/xdebug.off /usr/local/etc/php/conf.d/xdebug.ini && sudo pkill -o -USR2 php-fpm" > /usr/bin/xon && chmod +x /usr/bin/xon

CMD ["php-fpm"]
