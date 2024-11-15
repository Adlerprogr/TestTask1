## Описание проекта

Проект представляет собой систему бронирования билетов для событий. Система принимает заказы, генерирует уникальные баркоды для каждого билета и взаимодействует с внешним API для бронирования и подтверждения заказа. Так же для дальнейшей реализации проекта были нормализованы данные, которые позволят эффективно работать с несколькими типами билетов (взрослый, детский, льготный, групповой) и хранить отдельные баркоды для каждого билета.

## Структура проекта

Проект включает несколько основных частей:

1. **Database**: база данных MySQL для хранения данных о событиях и заказах.
2. **Services**: сервисы для бронирования билетов, генерации баркодов и взаимодействия с внешним API.
3. **Entity**: Entity представляет собой объект, который отражает сущность.
4. **Repository**: Repository отделяет бизнес-логику от кода, взаимодействующего с базой данных.

## Задания и их решение

### Задание №1

**Описание задачи**: Нужно создать систему, которая добавляет заказы в таблицу заказов MySQL, генерирует уникальные баркоды и взаимодействует с внешним API для бронирования и подтверждения заказа.

**Решение**:

1. Система генерирует уникальный баркод для каждого заказа, который не должен быть порядковым, с использованием случайных чисел.
2. При отправке запроса на бронирование, система проверяет, существует ли уже такой баркод в базе. Если да, генерируется новый баркод и запрос повторяется.
3. После успешного бронирования, система отправляет запрос на подтверждение бронирования.
4. Если подтверждение успешно, заказ сохраняется в базе данных.
5. Пример использования в директории:

 ```
 src/public/index.php
 ```

## Структура таблиц

### Таблица `events`
```sql
CREATE TABLE events (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    schedule DATETIME,
    price INT(11) NOT NULL
);
```

### Таблица `orders`
```sql
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
    FOREIGN KEY (event_id) REFERENCES events(event_id)
);
```

### Задание №2

**Описание задачи**: Нужно нормализовать таблицу заказов, чтобы поддерживать несколько типов билетов (взрослый, детский, льготный, групповой), каждый из которых будет иметь свой баркод.

**Решение**:

1. Введены новые таблицы для хранения типов билетов (`ticket_types`) и для хранения самих билетов (`tickets`), где каждый билет связан с конкретным заказом и типом билета.
2. Каждый билет имеет свой уникальный баркод, что позволяет проверять каждый билет отдельно.
3. Таблица `orders` теперь хранит общую информацию о заказе, включая сумму, но не привязывает напрямую каждый билет.

## Конечная структура таблиц

- **events**: Содержит информацию о событиях.
- **orders**: Содержит информацию о заказах (связаны с событиями).
- **ticket_types**: Содержит типы билетов (взрослый, детский, льготный, групповой).
- **tickets**: Содержит информацию о каждом билете, связанном с заказом и типом билета.

### Таблица `events`
```sql
CREATE TABLE events (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    schedule DATETIME,
    price INT(11) NOT NULL
);
```

### Таблица `orders`
```sql
CREATE TABLE orders (
     id INT AUTO_INCREMENT PRIMARY KEY,
     event_id INT NOT NULL,
     event_date DATE NOT NULL,
     total_price DECIMAL(10, 2) NOT NULL,
     FOREIGN KEY (event_id) REFERENCES events(id)
);
```

### Таблица `ticket_types`
```sql
CREATE TABLE ticket_types (
     id INT AUTO_INCREMENT PRIMARY KEY,
     name VARCHAR(255) NOT NULL,-- Название типа билета
     price DECIMAL(10, 2) NOT NULL-- Цена билета
);
```

### Таблица `tickets`
```sql
CREATE TABLE tickets (
      ticket_id INT AUTO_INCREMENT PRIMARY KEY,
      order_id INT NOT NULL,-- Иден. заказа
      ticket_type_id INT NOT NULL,-- Иден. типа билета
      barcode VARCHAR(255) NOT NULL,-- баркод
      FOREIGN KEY (order_id) REFERENCES orders(id),
      FOREIGN KEY (ticket_type_id) REFERENCES ticket_types(id)
);
```

### Задание №3

**Описание задачи**: Нужно сопроводить решение документацией.

## Инструкции по запуску

### 1. Установка

1. Склонировать репозиторий:
    ```bash
    git clone <git@github.com:Adlerprogr/TestTask1.git>
    ```

3. Создать базу данных:
    ```bash
    mysql -u root -p
    CREATE DATABASE my_database;
    USE my_database;
    ```

4. Импортировать схему базы данных:
    ```sql
    schema.sql
    ```

### 2. Настройка окружения

Проект использует Docker для настройки окружения. В Docker входят следующие компоненты:

- **Nginx** — веб-сервер для обработки запросов.
- **PHP-FPM** — интерпретатор PHP для обработки кода.
- **MySQL** — база данных для хранения информации о заказах и событиях.

### Основные файлы

- `.docker/conf/nginx/default.conf` — конфигурация Nginx.
- `Dockerfile` — создание образа PHP с нужными расширениями.
- `docker-compose.yml` — настройка сервисов проекта.

1. В файле `.env` настройте параметры подключения к базе данных:
    ```env
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=my_database
    DB_USERNAME=user
    DB_PASSWORD=yourpassword
    ```

2. Запустите контейнеры:
   ```bash
   docker-compose up -d
   ```

### 3. Запуск приложения

1. **Проверка**: Проект доступен на `http://localhost:82`, база данных на порту `3306`.


2. Пример запроса на бронирование:
    ```php
    $bookingService->bookTickets(
        eventId: 1,
        eventDate: '2024-11-20',
        ticketAdultPrice: 50,
        ticketAdultQuantity: 2,
        ticketKidPrice: 25,
        ticketKidQuantity: 3
    );
    ```

### 4. Примечания

- Процесс бронирования включает в себя несколько этапов, включая создание баркода, отправку запросов в стороннее API, и сохранение заказа в базе данных.
- В случае ошибки бронирования (например, "barcode already exists"), система повторяет попытку с новым баркодом.
- В случае ошибки подтверждения (например, "event cancelled"), система сообщает об ошибке.
