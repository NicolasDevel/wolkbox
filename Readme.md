# Instrucciones para Inicializar el Proyecto

Este proyecto utiliza Docker para levantar tres contenedores principales para el backend (Laravel) y un servidor independiente para la aplicación frontend (Vue). Sigue los pasos a continuación para inicializar correctamente el entorno de desarrollo.

## Prerrequisitos

Asegúrate de tener instalados los siguientes programas:

* Docker
* Docker Compose
* Node.js y npm (para manejar el frontend)

## Estructura del Proyecto

El repositorio tiene la siguiente estructura:

```
.
├── backend/          # Código fuente de Laravel
├── frontend/         # Aplicación Vue.js
├── docker-compose.yml
├── nginx/            # Configuración para Nginx
```

## Configuración e Inicialización

### 1. Backend

1. Copia el archivo `.env.example` dentro de la carpeta `backend` y renómbralo como `.env`:

   ```bash
   cp backend/.env.example backend/.env
   ```
2. Configura las variables de entorno en `backend/.env` si es necesario (especialmente la configuración de la base de datos).
3. Inicia los contenedores con Docker Compose:

   ```bash
   docker-compose up -d
   ```

   Esto levantará los contenedores de PHP, MySQL y Nginx.
4. Accede al contenedor PHP para ejecutar las migraciones:

   ```bash
   docker exec -it laravel-php bash
   php artisan migrate --seed
   ```

### 2. Frontend

1. Navega a la carpeta `frontend`:

   ```bash
   cd frontend
   ```
2. Instala las dependencias:

   ```bash
   npm install
   ```
3. Inicia el servidor de desarrollo:

   ```bash
   npm run dev
   ```

   Esto levantará la aplicación Vue en un servidor local. Por defecto, estará disponible en [http://localhost:8081](http://localhost:8081).

### 3. Nginx

El servidor Nginx está configurado para servir el backend en [http://localhost:8080](http://localhost:8080).

Si necesitas acceder al API desde el frontend, asegúrate de que las solicitudes estén apuntando al dominio correcto. Por ejemplo, configura la URL base del API en el frontend como `http://localhost:8080`.

## Notas Adicionales

* Si tienes problemas de permisos al manejar los archivos en `backend`, asegúrate de que los permisos sean correctos ejecutando:

  ```bash
  sudo chown -R $USER:$USER backend
  ```
* La base de datos MySQL estará disponible en `localhost:3306` con las credenciales configuradas en `docker-compose.yml`.

## Scripts Útiles

### Backend

* **Acceder al contenedor PHP:**

  ```bash
  docker exec -it laravel-php bash
  ```

* **Reiniciar el servidor Nginx:**

  ```bash
  docker restart laravel-nginx
  ```

### Frontend

* **Construir la aplicación para producción:**

  ```bash
  npm run build
  ```

  Los archivos generados estarán en la carpeta `dist/`.

## Documentación Adicional

* [Documentación de Laravel](https://laravel.com/docs)
* [Documentación de Vue.js](https://vuejs.org/guide/introduction.html)
* [Documentación de Docker](https://docs.docker.com/)
