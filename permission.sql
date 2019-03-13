CREATE DATABASE homestead;
CREATE USER `user`@`localhost` IDENTIFIED BY 'secret';
GRANT ALL ON homestead.* TO `user`@`localhost`;
FLUSH PRIVILEGES;
quit;