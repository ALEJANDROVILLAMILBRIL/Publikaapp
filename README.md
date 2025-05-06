# Pasos para instalar proyecto

1. Clonar el proyecto
2. Crear carpeta "mysql_data" en la raíz
3. Crear carpeta "src" en la raíz
4. Crear el archivo ".env" dentro de "mysql" con las  variables de entorno a utilizar
5. Ejecutar "docker-compose up -d"
6. Por último ejecutar "docker-compose run --rm composer create-project laravel/laravel ." para genera el proyecto Laravel en "src"
7. Generar Application key "docker-compose run --rm artisan key:generate"
8. Ejecutar migración de la BD: "docker-compose run --rm artisan migrate"

# Pasos para levantar proyecto

1. docker-compose down (apagar)
2. docker-compose up (levantar)