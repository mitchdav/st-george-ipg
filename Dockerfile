FROM ubuntu:16.04
MAINTAINER Mitchell Davis (mitch@wingmanwebdesign.com.au)

# The IPG version we want to target
ENV IPGVERSION 3.3

# The IPG client ID
ENV IPGCLIENTID 10000000

# The IPG certificate password
ENV IPGCERTIFICATEPASSWORD password

# Install dependencies
RUN apt-get update -y
RUN apt-get install -y software-properties-common python-software-properties swig gcc wget unzip tar
RUN LANG=C.UTF-8 add-apt-repository -y ppa:ondrej/php
RUN apt-get update -y
RUN apt-get install -y php5.6 php5.6-cli php5.6-common php5.6-mbstring php5.6-gd php5.6-intl php5.6-xml php5.6-mcrypt php5.6-zip php5.6-dev php5.6-xdebug php5.6-curl composer

# Link libraries
RUN ln -s /usr/lib/x86_64-linux-gnu/libcrypto.so.1.0.2 /lib/libcrypto.so.6
RUN ln -s /usr/lib/x86_64-linux-gnu/libssl.so.1.0.2 /lib/libssl.so.6

# Create directories
RUN mkdir -p /app
RUN mkdir -p /app/extension
RUN mkdir -p /app/library

WORKDIR /app

# Download extension files
RUN wget https://www.ipg.stgeorge.com.au/downloads/StGeorgeLinuxAPI-${IPGVERSION}.tar.gz -O extension.tar.gz
RUN tar -xzvf extension.tar.gz -C extension --strip-components=1

WORKDIR /app/extension

# Configure makefile
RUN sed -i 's\PHP_EXTENSIONS  = /usr/lib64/php/modules\PHP_EXTENSIONS  = /usr/lib/php/20131226\g' makefilePhp5
RUN sed -i 's\PHP_INCLUDE_DIR = /usr/include/php/\PHP_INCLUDE_DIR = /usr/include/php/20131226/\g' makefilePhp5

# Make extension
RUN make -f makefilePhp5

# Tell PHP to load the extension at runtime
RUN echo "extension=webpay_php.so" >> /etc/php/5.6/cli/php.ini

WORKDIR /app

# Download certificate
RUN wget https://www.ipg.stgeorge.com.au/downloads/cert.zip -O cert.zip
RUN unzip cert.zip -d library

WORKDIR /app/library

# Install app
COPY . /app/library

RUN composer install

CMD ["/bin/bash"]