# SarvCRM tech assessment task

A simple yet robust **Shopping List web application** built in **vanilla PHP (no frameworks)** for SarvCRM technical assessment.

## Features:
- Add, edit, delete shopping list items
- Mark items as checked/unchecked
- Full RESTful API for all actions (JSON)
- MVC architecture from scratch (custom PHP)
- OOP principles used throughout
- Simple and secure DB access with PDO
- Input validation

---

## Requirements:
- PHP 8.4
- Mysql
- Composer (for optional autoloading/PSR-4)


---

## ⚙️ Setup & Run

1. **Clone the repository:**

```sh
git clone https://github.com/mbahmanyar/sarvcrm-shopping-list.git
cd sarvcrm-shopping-list
```

2. **Install dependencies:**


```sh
composer install
```
3. **Copy `.env.example` to `.env`** (or configure `/config/config.php`) for DB credentials.


4. **Serve the project:**
    - You can use built-in PHP server for testing:

```sh
php -S localhost:8888 index.php
```

5. **Access:**  
   Open [http://localhost:8888](http://localhost:8888)


---

##️ Sample REST API Endpoints

- `GET    /api/shopping-items`                   List all items
- `POST   /api/shopping-items`                   Create new item
- `PUT    /api/shopping-items/{id}`              Update item (edit name)
- `DELETE /api/shopping-items/{id}`              Delete item
- `PATCH  /api/shopping-items/{id}/toggle-check` Mark as checked/unchecked

- `POST   /api/register`                         Sign-up
- `PATCH  /api/login`                            Sign-in


---
## Database Schema

```sql
create table shopping_items
(
   id         bigint auto_increment
        primary key,
   name       varchar(255)                       not null,
   note       text                               null,
   quantity   int      default 0                 null,
   is_checked tinyint(1)                         null,
   created_at datetime default CURRENT_TIMESTAMP null,
   updated_at datetime default CURRENT_TIMESTAMP null,
   user_id    bigint                             null
);

create table users
(
   id       int auto_increment
        primary key,
   email    varchar(255) not null,
   password varchar(255) not null
);


```


---

## Note:
Please see /database folder for DDL/seed data




