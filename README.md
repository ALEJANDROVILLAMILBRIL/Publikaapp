# Pasos para instalar proyecto

1. Clonar el proyecto
2. Crear carpeta "mysql_data" en la raíz
3. Crear carpeta "src" en la raíz
4. Crear el archivo ".env" dentro de "mysql" con las  variables de entorno a utilizar
5. Ejecutar "docker-compose up -d"
6. Por último ejecutar "docker-compose run --rm composer create-project laravel/laravel ." para genera el proyecto Laravel en "src"
8. Levantar el proyecto completo "docker-compose up"
9. El composer install "docker-compose run --rm composer install"
10. Generar Application key "docker-compose run --rm artisan key:generate"
11. Ejecutar migración de la BD: "docker-compose run --rm artisan migrate"

# Pasos para levantar proyecto

1. docker-compose down (apagar)
2. docker-compose up (levantar)

# Credenciales BD

## .env de MySql
MYSQL_DATABASE=publikapp
MYSQL_USER=user1
MYSQL_PASSWORD=user1.pass
MYSQL_ROOT_PASSWORD=root.pa55

## .env de Laravel
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=publikapp
DB_USERNAME=user1
DB_PASSWORD=user1.pass