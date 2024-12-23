# Fullstack News Aggregator

A **Dockerized** fullstack application that combines:

- **Laravel 11** (PHP 8.2, Apache) for the backend
- **Next.js** (Node 18) for the frontend
- **MySQL 8** for the database

## Table of Contents

1. [Features](#features)  
2. [Prerequisites](#prerequisites)  
3. [Project Structure](#project-structure)  
4. [Getting Started](#getting-started)  
   1. [Clone the Repository](#1-clone-the-repository)  
   2. [Configure Environment Variables](#2-configure-environment-variables)  
   3. [Build and Run Containers](#3-build-and-run-containers)  
   4. [Migrations & Seeding](#4-migrations--seeding)  
   5. [Run Background Jobs](#5-run-background-jobs)  
   6. [Access the Application](#6-access-the-application)  
5. [Troubleshooting](#troubleshooting)  
6. [Useful Docker Commands](#useful-docker-commands)  
7. [Contributing](#contributing)  
8. [License](#license)

---

## Features

- **Authentication**: Secure login/registration to manage user preferences.
- **Personalized News Feed**: Fetch and display news articles based on user preferences for categories, sources, and authors.
- **News Management**: Create, read, update, and delete news articles via the backend API.
- **Responsive Frontend**: Modern UI built with Next.js, optimized for all devices.
- **Background Jobs**: Scheduled tasks for syncing news articles from external APIs.
- **Dockerized Setup**: Easy local setup with Docker Compose.

---

## Prerequisites

1. **Docker** & **Docker Compose**
   - [Docker Desktop](https://www.docker.com/products/docker-desktop) for Windows/Mac
   - [Docker Engine](https://docs.docker.com/engine/install/) for Linux
2. **Git** (to clone the repository)

---

## Project Structure

```
root/
├── backend-news/        # Laravel application
├── news-frontend/       # Next.js frontend application
├── docker-compose.yml   # Docker Compose configuration
└── README.md            # Project documentation
```

---

## Getting Started

### 1. Clone the Repository

```bash
git clone <repository_url>
cd <project_directory>
```

### 2. Configure Environment Variables

1. **Backend**: Copy `.env.example` to `.env` in the `backend-news` directory and set the appropriate values.

   ```bash
   cp backend-news/.env.example backend-news/.env
   ```

   Update the following keys in the `.env` file:

   ```env
   DB_HOST=db
   DB_PORT=3306
   DB_DATABASE=laravel
   DB_USERNAME=root
   DB_PASSWORD=password
   APP_KEY=base64:wUxANfAqOx8DYm6i8dysaamTWJ4xPEbg/t23qrUXXpo=
   NEWSAPI_KEY=
   GUARDIAN_API_KEY=
   NYTIMES_API_KEY=
   ```

2. **Frontend**: Update the `API_URL` environment variable in `docker-compose.yml`:

   ```yaml
   environment:
     API_URL: http://localhost:8000/api
   ```

### 3. Build and Run Containers

Add the following keys (with your actual API credentials) in the **docker-compose.yml** file at the project root:
```
   - NEWSAPI_KEY=
   - GUARDIAN_API_KEY=
   - NYTIMES_API_KEY=
```

Run the following command to build and start all services:

```bash
docker-compose up --build
```

### 4. Migrations & Seeding

1. Run database migrations to set up the schema:

   ```bash
   docker exec -it laravel-app php artisan migrate
   ```

2. Seed the database with an admin user:

   ```bash
   docker exec -it laravel-app php artisan db:seed --class=AdminSeeder
   ```

### 5. Run Background Jobs

Fetch and sync news articles from external APIs by running the following command:

```bash
docker exec -it laravel-app php artisan news:fetch
```

### 6. Access the Application

- **Frontend**: Open [http://localhost:3000](http://localhost:3000) in your browser.
- **Backend API**: Accessible at [http://localhost:8000/api](http://localhost:8000/api).
- **Database**: MySQL is accessible at `localhost:3307`.

---

## Troubleshooting

1. **CORS Errors**:
   - Ensure the backend has proper CORS configuration in `config/cors.php`.

2. **Database Connection Issues**:
   - Verify database environment variables in `.env`.

3. **Permission Issues**:
   - Ensure appropriate permissions for the `storage` and `bootstrap/cache` directories in the Laravel app.

   ```bash
   docker exec -it laravel-app chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
   ```

---

## Useful Docker Commands

- **Stop all containers**:

  ```bash
  docker-compose down
  ```

- **Restart containers**:

  ```bash
  docker-compose up -d
  ```

- **Check logs**:

  ```bash
  docker logs <container_name>
  ```

---

## Contributing

Contributions are welcome! Please fork the repository and create a pull request.

---

## License

This project is licensed under the [MIT License](LICENSE).
