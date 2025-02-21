## Installation

### 1. Clone the repository
First, clone the repository to your local machine:

```bash
git clone https://github.com/leandro16197/challenge-rol.git

```
### 2. Set up Docker containers
    docker compose up -d --build
### 3. Run database migrations
    docker compose exec -it laravel-challenge bash
    php artisan migrate
### 4. Run database seeders 
    php artisan db:seed
### 5. Access the application
    http://localhost:8000

    para ingrese se pueden registrar o utilizar el usuario deprueba 

    mail: test@example.com
    password: secret
