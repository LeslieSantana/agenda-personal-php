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

## Instalación nueva en XAMPP
1. Copia la carpeta `agenda_personal` dentro de `C:\xampp\htdocs\`.
2. Abre el Panel de Control de XAMPP e inicia **Apache** y **MySQL**.
3. Entra a `http://localhost/phpmyadmin`.
4. Selecciona **Importar**, elige `database.sql` y pulsa **Continuar**. Este script crea la base de datos y sus tablas con las mejoras.
5. Revisa `config/database.php`. En una instalación típica de XAMPP el usuario es `root` y la contraseña está vacía.
6. Abre `http://localhost/agenda_personal/`.
7. Registra un usuario, inicia sesión y agrega tus contactos.

## Actualizar una instalación anterior sin perder contactos
1. Antes de modificar la base de datos, entra a phpMyAdmin, selecciona `agenda_personal` y usa **Exportar** para guardar una copia de seguridad.
2. En phpMyAdmin selecciona la base `agenda_personal` y abre la pestaña **Importar**.
3. Importa el archivo `migracion_mejoras.sql` una sola vez. Este script crea las categorías, agrega el campo de favoritos y asigna los contactos existentes a la categoría **Otro**.
4. Reemplaza los archivos PHP y CSS por la versión actualizada del proyecto.
5. Abre `http://localhost/agenda_personal/` y prueba las nuevas opciones.

> No importes `database.sql` sobre una instalación existente para aplicar las mejoras. Usa `migracion_mejoras.sql` para conservar los datos actuales.

## Funcionalidades
- Registro de usuarios con correo único.
- Inicio y cierre de sesión.
- Panel privado: cada usuario administra únicamente sus propios contactos.
- Crear, editar y eliminar contactos.
- Búsqueda de contactos por nombre, correo electrónico o ciudad.
- Ordenamiento alfabético por nombre o ciudad.
- Categorías: Familia, Amigos, Trabajo, Universidad y Otro.
- Marcado y filtrado de contactos favoritos.
- Confirmación antes de eliminar un contacto.
- Validación de datos en el servidor.

## Seguridad aplicada
- `password_hash()` almacena contraseñas como hashes y `password_verify()` las comprueba.
- Consultas PDO preparadas para reducir el riesgo de inyección SQL.
- Cookies de sesión `HttpOnly` y `SameSite=Lax`; `Secure` se activa cuando se usa HTTPS.
- Verificación de sesión en todas las páginas privadas.
- Token CSRF en formularios que modifican información.
- Escape de contenido con `htmlspecialchars()` al mostrar datos.
- Las consultas de lectura, edición y eliminación filtran por `id_usuario`, por lo que un usuario no puede operar sobre contactos ajenos aunque cambie el ID en la URL.

## Estructura
- `config/`: conexión a la base de datos.
- `includes/`: autenticación, funciones comunes y estructura visual.
- `assets/`: estilos CSS.
- `database.sql`: creación de la base de datos para una instalación nueva.
- `migracion_mejoras.sql`: actualización de una base existente conservando los contactos.
- Archivos PHP: registro, login, panel y operaciones de contactos.

## Repositorio y despliegue
Antes de entregar, completar este README con la URL pública del hosting y agregar capturas de pantalla del sistema funcionando. No subir contraseñas reales de bases de datos ni datos personales.
