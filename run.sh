sudo apt-get update

#install PHP
sudo apt-get install apache2
sudo apt-get install php libapache2-mod-php
sudo apt-get install php7.2-xml
sudo apt-get install php7.2-mysql
sudo apt-get install php-mbstring

#Install composer
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
sudo mv composer.phar /usr/local/bin/composer

#Install needed packages
composer install

php artisan key:generate
sudo mv .env.example .env

#Create database
sudo mysql -u root -p
CREATE DATABASE homestead;
CREATE USER `user`@`localhost` IDENTIFIED BY 'secret';
GRANT ALL ON homestead.* TO `user`@`localhost`;
FLUSH PRIVILEGES;
quit;

#Create database schema
php artisan config:clear
php artisan migrate

#Upload datadump
php artisan data-dump

#Serve
php artisan serve --port=8080



