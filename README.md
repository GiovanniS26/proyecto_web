# Proyecto web con Laravel

Este es un pequeño proyecto que demuestra las habilidades aprendidas con el framework Laravel. El objetivo de este proyecto era realizar un Landing Page, con su respectivo apartado de Autenticación, Registro y Administración de usuarios. Y así demostrar las habilidades aprendidads.

## Instalación

Para instalar el proyecto y ejecutarlo, tendremos que descargar las respectivas dependencias. Lo primero que tenemos que descargar será [XAMPP](https://www.apachefriends.org/download.html), el cuál nos trae PHP instalado. Una vez instalado XAMPP, debemos activar la extensión para los archivos .zip, para esto abriremos el archivo ``C:/xampp/php/php.ini``. Y buscaremos la instrucción ``;extension=zip``, removemos el ``;`` para descomentarla, y guardamos. Habido hecho este proceso podemos ejecutar XAMPP e iniciar Apache y MySQL.

Luego, tenemos que descargar [Composer](https://getcomposer.org/download/). Composer es un manejador de dependencias para PHP con el cual podremos descargar todas las dependencias de nuestro proyecto.

Entonces, vamos a la carpeta donde Apache va a exponer nuestro proyecto.

    cd C:/xampp/htdocs

Clonamos el repositorio

    git clone https://gitlab.com/GiovanniS26/proyecto_laravel.git

Entramos a la carpeta del proyecto

    cd proyecto_laravel

Procedemos a instalar las dependencias

    composer install

## Ejecutar Localmente

Una vez instaladas las dependencias procedemos a crear nuestra base de datos el cual deberá de tener por nombre ``proyecto_databox``, si es que se utilizó el archivo ``.env.example`` como se explica en la siguiente parte. Sino, entonces coloca el nombre que decidiste elegir.

Luego, debemos dirigirnos a la raíz del proyecto y crear nuestro archivo ``.env`` el cual alojará todas nuestras variables de entorno, dentro del proyecto existe un archivo de ejemplo ``.env.example`` que podemos usar para ejecutarlo, simplemente lo copiamos y le cambiamos el nombre a ``.env`` Depués podemos iniciar nuestras migraciones, para esto necesitamos que ``MySQL`` se esté ejecutando.

Para que funcionen los correos de restaurar contraseñas, se debe configurar el smtp con el siguiente mailer:

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=proyectowebuc@gmail.com
MAIL_PASSWORD=zfaogvsprizhlmgf
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=proyectowebuc@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

Este es un correo creado exclusivamente para enviar los correos predeterminados de Laravel para recuperar contraseñas.

Luego de esto, usamos el comando:

    php artisan migrate

Una vez hecho todo este proceso nuestra página estará disponible para su prueba usando la siguiente url:

    http://localhost:80/proyecto_laravel/public/

## Acceso

Por defecto al hacer el migrate se crea un primer usuario administrador:

    Email: admin@admin.com
    Password: admin1234

Con este usuario se puede acceder y crear otros usuaios administradores o de otro tipo de rol si así se desea. Además, también puede editar y eliminar usuarios. Y en lo que respecta a los roles, un usuario administrador también puede crear y editar roles, pero hay que tomar en cuenta de que solo se pueden eliminar y editar roles que no tengan usuarios adjuntos, esto con el fin de proteger la integridad de los datos del usuario. Por lo que si se requiere editar o eliminar roles, tendrán que eliminar todos los usuarios adjuntos a ese rol.

También existe la posibilidad de hacer una solicitud de feature al desarrollador para poder agregarle varios roles a un mismo usuario. Pero así como desearías que nunca se te vaya la luz, esto tampoco sucederá.

## License

[MIT](https://choosealicense.com/licenses/mit/)
