# Docker Compose Laravel + MySQL

1. Copy the example environment file:
   
   ```sh
   cp blog-api/.env.docker blog-api/.env
   ```

2. Build and start the containers:
   
   ```sh
   docker-compose up --build
   ```

3. Install Composer dependencies (in a new terminal):
   
   ```sh
   docker-compose exec app composer install
   ```

4. Generate the Laravel application key:
   
   ```sh
   docker-compose exec app php artisan key:generate
   ```

5. (Optional) Run migrations:
   
   ```sh
   docker-compose exec app php artisan migrate
   ```

The app will be running on port 9000 (PHP-FPM). You can use a web server (like Nginx) or Laravel's built-in server for local development.
