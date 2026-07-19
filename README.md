# TA ICETY - Learning Management System (LMS)

## Tentang Project

TA ICETY merupakan aplikasi Learning Management System (LMS) berbasis Laravel yang dikembangkan sebagai bagian dari tugas akhir. Sistem ini digunakan untuk mengelola proses pembelajaran, mulai dari manajemen course, aktivitas pembelajaran, ujian, sertifikat, hingga pembayaran secara online.

Project ini menggunakan:

- Laravel 10
- PHP 8.3
- MySQL 8
- Redis
- Docker
- Nginx
- Xendit Payment Gateway
- AWS S3 Storage
- Bootstrap
- jQuery

---

# Fitur

## Authentication

- Login
- Register
- Forgot Password
- Email Verification
- Role Management

---

## Dashboard

- Dashboard Admin
- Dashboard Instructor
- Dashboard Student

---

## Course Management

- CRUD Course
- Category Course
- Course Thumbnail
- Course Banner
- Course Detail
- Publish / Draft
- Course Progress

---

## Activity Management

- Video Learning
- Reading Material
- Download Material
- Assignment
- Quiz
- Final Exam

---

## Certificate

- Generate Certificate
- Download Certificate
- Certificate Validation
- QR Code Certificate

---

## User Management

- Student Management
- Instructor Management
- Admin Management
- Profile Management

---

## Payment

- Xendit Integration
- Invoice
- Payment Verification
- Certificate Payment
- Final Exam Payment

---

## Promo

- Promo Management
- Redeem Code
- Claim Promo
- Usage Limitation

---

## Report

- User Report
- Payment Report
- Course Report
- Certificate Report

---

## Email

- Email Notification
- Forgot Password
- Registration Email

---

## Multi Language

- Bahasa Indonesia
- English

---

# Tech Stack

Backend

- Laravel 10
- PHP 8.3

Frontend

- Bootstrap
- JQuery
- JavaScript

Database

- MySQL 8

Infrastructure

- Docker
- Docker Compose
- Nginx
- Redis

Storage

- AWS S3

Payment

- Xendit

---

# Requirement

- Docker Desktop
- Docker Compose
- Git

---

# Installation

## Clone Repository

```bash
git clone https://github.com/muhsinulfikri/ta-icety.git

cd ta-icety
```

---

## Copy Environment

```bash
cp .env.example .env
```

atau gunakan file `.env` yang telah disediakan.

---

## Build Docker

```bash
docker compose up -d --build
```

---

## Install Dependency

```bash
docker compose exec app composer install
```

---

## Generate Application Key

```bash
docker compose exec app php artisan key:generate
```

---

## Storage Link

```bash
docker compose exec app php artisan storage:link
```

---

## Import Database

Project ini **tidak menggunakan Laravel Migration**.

Import database melalui phpMyAdmin atau menggunakan command berikut:

```bash
docker compose exec -T mysql mysql -uroot -proot dev_icety < database/dev_icety.sql
```

---

## Clear Cache

```bash
docker compose exec app php artisan optimize:clear
```

---

# Docker Services

| Service | URL |
|----------|-----|
| Laravel | http://localhost:8000 |
| phpMyAdmin | http://localhost:8081 |

---

# Default Database

Host

```
mysql
```

Port

```
3306
```

Database

```
dev_icety
```

Username

```
root
```

Password

```
root
```

---

# Folder Structure

```
docker/
├── nginx
├── php

app/
bootstrap/
config/
database/
public/
resources/
routes/
storage/
```

---

# Environment

Pastikan konfigurasi berikut sesuai:

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=dev_icety
DB_USERNAME=root
DB_PASSWORD=root

REDIS_HOST=redis
REDIS_PORT=6379
```

---

# Development

Masuk ke container

```bash
docker compose exec app bash
```

Composer

```bash
composer install
```

Artisan

```bash
php artisan
```

---

# Build Ulang

```bash
docker compose down

docker compose up -d --build
```

---

# Stop Container

```bash
docker compose down
```

---

# License

This project is developed for educational purposes as part of the Final Project at Universitas Bhinneka Nusantara.
