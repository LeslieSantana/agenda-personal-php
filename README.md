# Mi Agenda Personal

Aplicación web académica para administrar una agenda de contactos privada por usuario.

## Tecnologías
- PHP 8.0 o superior
- MySQL 5.7+ / MariaDB
- PDO para consultas preparadas
- HTML5 y CSS3

## Requisitos
- XAMPP (Apache, PHP y MySQL)
- Navegador web
- phpMyAdmin (incluido en XAMPP)

## Instalación en XAMPP
1. Copia la carpeta `agenda_personal` dentro de `C:\xampp\htdocs\`.
2. Abre el Panel de Control de XAMPP e inicia **Apache** y **MySQL**.
3. Entra a `http://localhost/phpmyadmin`.
4. Selecciona **Importar**, elige el archivo `database.sql` y pulsa **Continuar**.
5. Revisa `config/database.php`. En una instalación típica de XAMPP el usuario es `root` y la contraseña está vacía.
6. Abre `http://localhost/agenda_personal/`.
7. Registra un usuario, inicia sesión y agrega tus contactos.

## Funcionalidades
- Registro de usuarios con correo único.
- Inicio y cierre de sesión.
- Panel privado con los contactos del usuario autenticado.
- Crear, editar y eliminar contactos.
- Confirmación antes de eliminar.
- Validación de datos en el servidor.

## Seguridad aplicada
- `password_hash()` almacena contraseñas como hashes y `password_verify()` las comprueba.
- Consultas PDO preparadas para reducir el riesgo de inyección SQL.
- Regeneración del ID de sesión al iniciar sesión.
- Cookies de sesión `HttpOnly` y `SameSite=Lax`; `Secure` se activa cuando se usa HTTPS.
- Verificación de sesión en todas las páginas privadas.
- Token CSRF en formularios que modifican información.
- Escape de contenido con `htmlspecialchars()` al mostrar datos.
- Las consultas de lectura, edición y eliminación filtran por `id_usuario`, por lo que un usuario no puede operar sobre contactos ajenos aunque cambie el ID en la URL.

## Estructura
- `config/`: conexión a la base de datos.
- `includes/`: autenticación, funciones comunes y estructura visual.
- `assets/`: estilos CSS.
- `database.sql`: creación de la base de datos y tablas.
- Archivos PHP: registro, login, panel y operaciones de contactos.

## Repositorio
Crea un repositorio público en GitHub y sube el contenido de esta carpeta. No subas contraseñas reales de bases de datos ni datos personales.
