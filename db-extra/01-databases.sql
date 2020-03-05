# create databases
CREATE DATABASE IF NOT EXISTS `test`;
CREATE DATABASE IF NOT EXISTS `testing`;

# create root user and grant rights
# CREATE USER 'root'@'localhost' IDENTIFIED BY 'local';
GRANT ALL PRIVILEGES ON *.* TO test;