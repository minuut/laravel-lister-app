
## Getting Started

Follow the steps below to get the project up and running on your local machine.

### Prerequisites

- PHP (>= 7.4)
- Composer
- MySQL or any other compatible database
- Git

### Clone the Repository

First, clone this repository to your local machine using the following command:

```bash
git clone https://github.com/minuut/laravel-lister-app.git
```

### Install Dependencies
Navigate to the project directory and install the required dependencies using Composer:
```bash
cd laravel-lister-app
composer install
```
### Set Up Environment Configuration
Create a copy of the .env.example file and save it as .env:
```bash
cp .env.example .env
```
### Generate Application Key
Generate the application key using the artisan command:
```bash
php artisan key:generate
```
### Run Migrations
Run the database migrations to create the required tables:
```bash
php artisan migrate
```
### Link Storage
To make sure uploaded files are accessible publicly, you need to create a symbolic link to the public/storage directory:
```bash
php artisan storage:link
```
### Serve the Application
Finally, serve the application using the built-in development server:
```bash
php artisan serve
```

