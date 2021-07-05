FROM php:7.4-fpm

ARG UID
ARG GID

# Alterar o ID do usuário e do grupo www-data para ser o mesmo do
# host do sistema (geralmente o usuário é 1000 e o grupo também é 1000)
RUN usermod -u ${UID} -s /bin/bash www-data && groupmod -g ${GID} www-data

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
    curl \
    openssl \
    nano \
    locales \
    tzdata \
    dos2unix \
    iproute2 \
    git \
    supervisor

# Define locale PT-BR
RUN echo "pt_BR.UTF-8 UTF-8" >> /etc/locale.gen && \
    locale-gen "pt_BR.UTF-8" && \
    dpkg-reconfigure --frontend=noninteractive locales && \
    update-locale LANG="pt_BR.UTF-8"

# Define Timezone America/Sao_Paulo
RUN ln -fs /usr/share/zoneinfo/America/Sao_Paulo /etc/localtime && \
    dpkg-reconfigure -f noninteractive tzdata

ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/
RUN chmod uga+x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions \
    pdo_pgsql \
    gd \
    zip \
    soap

WORKDIR /var/www

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sL https://deb.nodesource.com/setup_12.x -o nodesource_setup.sh && \
    bash nodesource_setup.sh && \
    apt-get install -y nodejs && \
    npm install --global yarn && \
    npm install --global gulp-cli

RUN rm -rf /var/www/html && \
    chown -R ${UID}:${GID} /var/www

VOLUME /var/www

COPY conf.d/* /usr/local/etc/php/conf.d/
COPY pool.d/* /usr/local/etc/php-fpm.d/

ADD entrypoint.sh /entrypoint.sh

RUN ["chmod", "+x", "/entrypoint.sh"]

ENTRYPOINT ["/entrypoint.sh"]
