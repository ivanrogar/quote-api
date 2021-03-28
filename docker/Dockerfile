FROM centos:centos8
MAINTAINER Ivan Rogar <ivan.rogar1@gmail.com>

# utilities
RUN yum -y install epel-release

RUN yum -y install sudo acl tar curl wget unzip git vim nano \
iproute python2-setuptools hostname inotify-tools yum-utils which \
openssh-server openssh-clients

# root
RUN echo root:docker | chpasswd && yum install -y passwd

# Python
RUN yum -y install python2-setuptools \
&& mkdir -p /var/log/supervisor \
&& yum -y install supervisor

RUN groupadd -g 1000 app \
&& useradd -g 1000 -u 1000 -d /home/app -s /bin/bash app

RUN echo app:docker | chpasswd

# Apache
RUN yum -y install httpd mod_ssl exim

# apache & user groups
RUN usermod -a -G apache app
RUN usermod -a -G app apache
RUN usermod -a -G 1000 apache

# PHP
RUN dnf config-manager --set-enabled PowerTools
RUN dnf -y install https://dl.fedoraproject.org/pub/epel/epel-release-latest-8.noarch.rpm
RUN dnf -y install https://rpms.remirepo.net/enterprise/remi-release-8.rpm
RUN dnf -y module enable php:remi-7.4
RUN dnf -y upgrade
RUN dnf -y install php php-devel php-gd php-pdo php-soap php-xmlrpc php-xml php-bcmath php-intl php-json php-mbstring php-mcrypt php-mysqlnd php-opcache php-pdo-dblib php-amqp php-zmq php-zip

RUN cd /root

# Composer
RUN curl https://getcomposer.org/download/1.10.20/composer.phar --output composer.phar
RUN mv /composer.phar /usr/local/bin/composer
RUN chmod +x /usr/local/bin/composer

RUN cd /

RUN yum -y clean all

# Apache config
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/httpd/conf/httpd.conf \
&& chown app:apache /var/www/html \
&& chmod g+s /var/www/html

# PHP config
RUN sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 512M/g' /etc/php.ini \
&& sed -i 's/post_max_size = 8M/post_max_size = 512M/g' /etc/php.ini \
&& sed -i 's/memory_limit = 128M/memory_limit = 8192M/g' /etc/php.ini \
&& sed -i 's/realpath_cache_size = 16K/realpath_cache_size = 16M/g' /etc/php.ini \
&& sed -i 's/;date.timezone =/date.timezone = Europe\/Zagreb/g' /etc/php.ini

# System timezone
RUN ln -sf /usr/share/zoneinfo/UTC /etc/localtime \
	&& echo "NETWORKING=yes" > /etc/sysconfig/network

RUN cd /

COPY supervisord.conf /etc/supervisord.conf

# fix apache cert
RUN /usr/libexec/httpd-ssl-gencerts

COPY 00-mpm.conf /etc/httpd/conf.modules.d/
COPY httpd.conf /etc/httpd/conf/
COPY vhost.conf /etc/httpd/conf.d/

RUN cd /var/www/html

RUN cd /

EXPOSE 80

CMD bash
