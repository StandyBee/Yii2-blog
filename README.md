# Yii2 Blog

This is a simple blog built with Yii2. The blog allows users to create and publish blog posts.

## Features

- User authentication and authorization system
- Dashboard for managing posts
- Search functionality
- Responsive design

## Installation

1. Clone the repository: `git clone https://github.com/StandyBee/Yii2-blog.git`
2. Install dependencies: `composer install`
3. Create a new PostgreSQL database
4. Create config/db.php file
    ```shell
    touch config/db.php
    ```
    and put there following configuration with your database credentials
    ```shell
    <?php
    
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'pgsql:host=localhost;port=5432;dbname=database_name',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
    ];
    ```
7. Run database migrations: `php yii migrate`
8. Start the development server: `php yii serve`

## Usage

To access the blog, open your browser and go to `http://localhost:8080`. You can create a new account or log in with the default admin account:

- Username: admin
- Password: admin

Once logged in, you can create new posts and manage existing posts.
