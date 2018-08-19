FROM php:7.1-cli-alpine

RUN apk update \
    && apk add --no-cache $PHPIZE_DEPS \
        ca-certificates \
        git \
        zip \
        unzip \
        wget \
        bash \
        zsh \
    && update-ca-certificates \
    && pecl install xdebug-2.5.0

RUN docker-php-ext-install pdo_mysql bcmath

RUN docker-php-ext-enable xdebug \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_autostart=on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_connect_back=off" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN addgroup -g 1000 1000
RUN adduser -u 1000 -G 1000 -D 1000

RUN echo 'memory_limit = 512M' > /usr/local/etc/php/conf.d/memory_limit.ini

USER 1000

#oh my zsh
RUN wget https://github.com/robbyrussell/oh-my-zsh/raw/master/tools/install.sh -O - | zsh || true
RUN echo 'export ZSH=/home/1000/.oh-my-zsh' > ~/.zshrc \
    && echo 'ZSH_THEME="simple"' >> ~/.zshrc \
    && echo 'plugins=(npm)' >> ~/.zshrc \
    && echo 'source $ZSH/oh-my-zsh.sh' >> ~/.zshrc \
    && echo 'PROMPT="%{$fg_bold[yellow]%}php_cli@docker_importer_csv %{$fg_bold[blue]%}%(!.%1~.%~)%{$reset_color%} "' > ~/.oh-my-zsh/themes/simple.zsh-theme

WORKDIR /var/www/importer_csv