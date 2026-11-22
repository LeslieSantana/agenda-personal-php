# Mi Agenda Personal de Contactos

Aplicación web académica desarrollada en PHP y MySQL para administrar contactos personales de forma privada. Permite registrar usuarios, gestionar sus contactos y organizarlos mediante categorías y favoritos.

## Aplicación publicada

**Enlace público:** https://agenda-contactosllsantana.rf.gd/

**Repositorio GitHub:** https://github.com/LeslieSantana/agenda-personal-php

## Objetivo del proyecto

Desarrollar una aplicación web que facilite la administración de contactos personales, incorporando herramientas de búsqueda, organización y clasificación, así como mecanismos de seguridad para proteger la información de cada usuario.

## Tecnologías utilizadas

- PHP 8.0 o superior.
- MySQL / MariaDB.
- PDO para consultas preparadas.
- HTML5.
- CSS3.
- Apache mediante XAMPP.
- InfinityFree para el alojamiento web.

## Funcionalidades principales

- Registro de usuarios con correo electrónico único.
- Inicio y cierre de sesión.
- Panel privado para administrar contactos.
- Crear, editar y eliminar contactos.
- Búsqueda por nombre, correo electrónico o ciudad.
- Ordenamiento de contactos por nombre o ciudad.
- Organización mediante categorías: Familia, Amigos, Trabajo, Universidad y Otro.
- Marcado y filtrado de contactos favoritos.
- Validación de datos en el servidor.
- Confirmación antes de eliminar contactos.

## Mejoras implementadas

1. **Búsqueda de contactos:** permite localizar registros mediante el nombre, correo electrónico o ciudad.
2. **Ordenamiento:** permite organizar los contactos alfabéticamente por nombre o ciudad.
3. **Categorías:** permite clasificar los contactos según su relación o actividad.
4. **Favoritos:** permite marcar contactos importantes y filtrarlos para acceder rápidamente a ellos.
   <img width="1326" height="632" alt="image" src="https://github.com/user-attachments/assets/a5b25c99-9710-4172-9ab4-b6976915f25d" />


## Seguridad aplicada

- Contraseñas protegidas mediante `password_hash()` y verificadas con `password_verify()`.
- Consultas preparadas mediante PDO para reducir el riesgo de inyección SQL.
- Protección de sesiones.
- Token CSRF en formularios que modifican información.
- Escape de contenido mediante `htmlspecialchars()`.
- Restricción de acceso a los contactos pertenecientes a otros usuarios.

## Estructura del proyecto

- `assets/`: archivos de estilos y recursos visuales.
- `config/`: configuración y conexión con la base de datos.
- `includes/`: autenticación, funciones comunes y elementos visuales.
- `database/`: archivos relacionados con la base de datos.
- Archivos PHP: registro, inicio de sesión, panel y operaciones de contactos.
- `README.md`: documentación del proyecto.

## Instalación local en XAMPP

1. Instalar XAMPP.
2. Copiar la carpeta `agenda_personal` dentro de `C:\xampp\htdocs\`.
3. Iniciar Apache y MySQL desde el panel de XAMPP.
4. Abrir `http://localhost/phpmyadmin`.
5. Importar el archivo `database.sql`.
6. Configurar `config/database.php` con los datos de conexión local.
7. Abrir `http://localhost/agenda_personal/`.
8. Registrar un usuario e iniciar sesión para comenzar a utilizar la aplicación.

## Base de datos

El proyecto incluye dos archivos SQL:

- `database.sql`: permite crear la base de datos y sus tablas para una instalación nueva.
- `migracion_mejoras.sql`: permite actualizar una instalación anterior, conservando los contactos existentes y agregando las nuevas funcionalidades.

Antes de realizar una migración, se recomienda generar una copia de seguridad de la base de datos.

## Despliegue web

La aplicación fue publicada utilizando el servicio de alojamiento gratuito InfinityFree.

**URL de acceso:** https://agenda-contactosllsantana.rf.gd/

La base de datos se configuró en el servidor de alojamiento para permitir el funcionamiento de la aplicación en Internet.

## Evidencias del proyecto

Se incorporarán capturas de pantalla que permitan observar:

- Página de inicio de sesión.
- Registro de usuarios.
- Panel principal de contactos.
- Búsqueda y ordenamiento.
- Clasificación por categorías.
- Gestión de contactos favoritos.
- Aplicación funcionando desde el alojamiento web.

## Autora - Leslie Santana Daza

Proyecto académico desarrollado como práctica de programación web, utilizando PHP y MySQL.
