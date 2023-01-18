CREATE DATABASE taskforce
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE taskforce;

SET GLOBAL time_zone = 'Europe/Moscow';
SET GLOBAL sql_mode = (SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));

CREATE TABLE users
(
    id       INT AUTO_INCREMENT PRIMARY KEY,
    email    VARCHAR(128) NOT NULL UNIQUE,
    name     VARCHAR(32)  NOT NULL UNIQUE,
    password CHAR(64)     NOT NULL,
    avatar   VARCHAR(255) NULL,
    city     VARCHAR(255) NULL,
    dt_add   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE category
(
    id       INT AUTO_INCREMENT PRIMARY KEY,
    name     VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE statuses
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name     VARCHAR(32)  NOT NULL UNIQUE
);

CREATE TABLE cities
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE task
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    title    VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    location VARCHAR(255) NULL,
    budget TINYINT,
    term TIMESTAMP NULL,
    performer_id INT NOT NULL,
    client_id INT NULL,
    status_id INT NOT NULL,
    city_id INT NULL,
    city_x INT NULL,
    city_y INT NULL,
    dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT task_performer_ref FOREIGN KEY (performer_id) REFERENCES users (id) ON DELETE CASCADE,
    CONSTRAINT task_client_ref FOREIGN KEY (client_id) REFERENCES users (id),
    CONSTRAINT task_city_ref FOREIGN KEY (city_id) REFERENCES cities (id),
    CONSTRAINT task_status_ref FOREIGN KEY (status_id) REFERENCES statuses (id) ON DELETE CASCADE
);
