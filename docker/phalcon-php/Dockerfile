FROM phalconphp/php-fpm

RUN apt-get update && \
	apt-get install git zip -y && \
	apt-get autoremove -y

CMD ["php-fpm"]

EXPOSE 9000