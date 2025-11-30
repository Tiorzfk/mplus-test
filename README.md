# Mplus API

Laravel-based API with custom authentication, Google & Facebook social login, and JWT-protected routes.

---

## Table of Contents

1. [Installation](#installation)
2. [Running the Application](#running-the-application)
3. [API Documentation](#api-documentation)

---

## Installation (Manual / Local Machine)

### Prerequisites

-   PHP 8.2+
-   Composer
-   MySQL 8+
-   Git
-   PHP extensions: pdo_mysql, mbstring, zip

### Clone Repository

```bash
git clone <repo-url>
cd <repo-folder>
```

### Install Dependencies

```bash
composer install
```

### Copy Environment File

```bash
cp .env.example .env
```

### Update .env values (database, JWT, Google & Facebook OAuth keys).

### Generate App Key

```bash
php artisan key:generate
```

### Run Migrations

```bash
php artisan migrate
```

### Generate API Docs

```bash
php artisan scribe:generate
```

## Installation (with docker)

### Prerequisites

-   Docker & Docker Compose
-   Git

### Clone Repository

```bash
git clone <repo-url>
cd <repo-folder>
```

### Start Application

Simply run:

```bash
docker-compose -f docker-compose.dev.yml up -d --build
```

### Run Migrations & Generate App Key

```bash
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
docker-compose exec app php artisan scribe:generate
```

## API Documentation

### Once the app is running, open your browser:

```
http://127.0.0.1:8000/docs
```
