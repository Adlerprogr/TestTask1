CREATE DATABASE my_database;
USE my_database;

CREATE TABLE events (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        schedule DATETIME,
        price INT(11) NOT NULL
);

CREATE TABLE orders (
        id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        event_id INT(11) UNSIGNED NOT NULL,
        event_date VARCHAR(10) NOT NULL,
        ticket_adult_price INT(11) NOT NULL,
        ticket_adult_quantity INT(11) NOT NULL,
        ticket_kid_price INT(11) NOT NULL,
        ticket_kid_quantity INT(11) NOT NULL,
        barcode VARCHAR(120) NOT NULL UNIQUE,
        equal_price INT(11) NOT NULL,
        created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (event_id) REFERENCES events(id)
);

INSERT INTO events (id, name, description, schedule, price) VALUES (1, 'Hallo Name', 'Hallo', '2024-11-12 21:50:47', '12999');

CREATE TABLE ticket_types (
          id INT AUTO_INCREMENT PRIMARY KEY,
          name VARCHAR(255) NOT NULL,-- Название типа билета
          price DECIMAL(10, 2) NOT NULL-- Цена билета
);

CREATE TABLE orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        event_id INT NOT NULL,
        event_date DATE NOT NULL,
        total_price DECIMAL(10, 2) NOT NULL,
        FOREIGN KEY (event_id) REFERENCES events(id)
);

CREATE TABLE tickets (
         ticket_id INT AUTO_INCREMENT PRIMARY KEY,
         order_id INT NOT NULL,-- Иден. заказа
         ticket_type_id INT NOT NULL,-- Иден. типа билета
         barcode VARCHAR(255) NOT NULL,-- баркод
         FOREIGN KEY (order_id) REFERENCES orders(id),
         FOREIGN KEY (ticket_type_id) REFERENCES ticket_types(id)
);