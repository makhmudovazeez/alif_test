FROM phpdockerio/php:7.4-fpm
WORKDIR "/application"
COPY ./.. .

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install imagemagick php7.4-imagick php7.4-gd php7.4-mysql nano php7.4-redis php7.4-bcmath php7.4-gmp php7.4-zmq git \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN rm -rf /application/docker && chmod -R 777 /application/bootstrap && chmod -R 777 /application/storage
