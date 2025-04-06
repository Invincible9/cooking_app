# Symfony Cooking App

This is a Symfony-based web application for learning how to cook. 
It includes user authentication, role-based access control, and custom logic limiting access based on user activity.

# Features

- User registration and login (email, username, password)
- Role-based access (`ROLE_ADMIN`, `ROLE_USER`)
- Course access restrictions based on:
  - User role
  - Number of course views
  - Time since last course view (configurable)
- Fixtures to demo the app in dev mode
- Clean service-based business logic
- Symfony coding standards & unit tests for core rules

# Requirements

- PHP 8.2+
- Composer
- Symfony CLI (optional but helpful)
- MySQL

# Installation

1.  **Clone the repository**
     - git clone 'https://github.com/Invincible9/cooking_app.git'
     - cd cooking_app

2. **Install dependencies**
   - composer install

3. **Configure your environment**
   - Create **.env.local** file
   - Edit **.env.local** and set your database connection
   - DATABASE_URL="mysql://db_user:db_pass@127.0.0.1:3306/your_db?serverVersion=8.0"

4. **Create the database**
   - php bin/console doctrine:database:create
   - php bin/console doctrine:migrations:migrate

5. **Load some data**
   - php bin/console doctrine:fixtures:load

6. **Start the dev server**
   - symfony server:start