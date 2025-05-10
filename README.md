# Pasos para instalar proyecto

1. Clonar el proyecto "git clone [url]"
2. Crear carpeta "mysql_data" en la raíz
3. Crear carpeta "src" en la raíz
4. Crear el archivo ".env" dentro de "mysql" con las  variables de entorno a utilizar
5. Crear el archivo ".env" dentro de "src" con las  variables de entorno a utilizar
6. Levantar el proyecto completo "docker-compose up"
7. El composer install "docker-compose run --rm composer install"
8. El npm install "docker-compose run --rm node npm install"
9. Arrancar el vite build de Bleeze "docker-compose run --rm node npm run build"
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