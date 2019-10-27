#!/bin/bash
yum install nginx &&
yum -y install wget vim pcre pcre-devel openssl openssl-devel libicu-devel gcc gcc-c++ autoconf libjpeg libjpeg-devel libpng libpng-devel freetype freetype-devel libxml2 libxml2-devel zlib zlib-devel glibc glibc-devel glib2 glib2-devel ncurses ncurses-devel curl curl-devel krb5-devel libidn libidn-devel openldap openldap-devel nss_ldap jemalloc-devel cmake boost-devel bison automake libevent libevent-devel gd gd-devel libtool* libmcrypt libmcrypt-devel mcrypt mhash libxslt libxslt-devel readline readline-devel gmp gmp-devel libcurl libcurl-devel openjpeg-devel &&
cd /usr/local/src/ &&
wget http://am1.php.net/distributions/php-7.1.26.tar.gz &&
tar xvf php-7.1.26.tar.gz &&
rm php-7.1.26.tar.gz &&
cd php-7.1.26/ &&
cp -frp /usr/lib64/libldap* /usr/lib &&
./configure --prefix=/usr/local/php --with-config-file-path=/usr/local/php/etc --enable-fpm --with-fpm-user=www --with-fpm-group=www --enable-mysqlnd --with-mysqli=mysqlnd --with-pdo-mysql=mysqlnd --enable-mysqlnd-compression-support --with-iconv-dir --with-freetype-dir --with-jpeg-dir --with-png-dir --with-zlib --with-libxml-dir --enable-xml --disable-rpath --enable-bcmath --enable-shmop --enable-sysvsem --enable-inline-optimization --with-curl --enable-mbregex --enable-mbstring --enable-intl --with-mcrypt --with-libmbfl --enable-ftp --with-gd --enable-gd-jis-conv --enable-gd-native-ttf --with-openssl --with-mhash --enable-pcntl --enable-sockets --with-xmlrpc --enable-zip --enable-soap --with-gettext --disable-fileinfo --enable-opcache --with-pear --enable-maintainer-zts --with-ldap=shared --without-gdbm &&
make && make install && 
cp ./php.ini-production /usr/local/php/etc/php.ini &&
groupadd www && 
useradd -g www www && 
cp /usr/local/php/etc/php-fpm.conf.default /usr/local/php/etc/php-fpm.conf &&
cp /usr/local/php/etc/php-fpm.d/www.conf.default /usr/local/php/etc/php-fpm.d/www.conf &&
ln /usr/local/php/bin/php /usr/bin/php &&
ln /usr/local/php/sbin/php-fpm /usr/bin/php-fpm 
