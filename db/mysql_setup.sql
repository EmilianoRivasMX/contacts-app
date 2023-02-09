DROP DATABASE IF EXISTS contacts_app;
CREATE DATABASE contacts_app;
USE contacts_app;

CREATE TABLE contacts (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50),
    phone VARCHAR(15) 
); 

INSERT INTO contacts(name, phone) VALUES('Juan', '5500125396');
INSERT INTO contacts(name, phone) VALUES('Axel', '5544237601');
INSERT INTO contacts(name, phone) VALUES('Paola', '5512549878');