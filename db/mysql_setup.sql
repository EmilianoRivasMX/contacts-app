DROP DATABASE IF EXISTS contacts_app;
CREATE DATABASE contacts_app;
USE contacts_app;

CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50),
    email VARCHAR(50) UNIQUE,
    password VARCHAR(255)
);

INSERT INTO users(name, email, password) VALUES("test", "test@test.com", "123456");

CREATE TABLE contacts (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50),
    phone VARCHAR(15),
    user_id INT NOT NULL,

    FOREIGN KEY(user_id) REFERENCES users(id)
); 

INSERT INTO contacts(name, phone, user_id) VALUES('Juan', '5500125396', '1');
INSERT INTO contacts(name, phone, user_id) VALUES('Axel', '5544237601', '1');
INSERT INTO contacts(name, phone, user_id) VALUES('Paola', '5512549878', '1');