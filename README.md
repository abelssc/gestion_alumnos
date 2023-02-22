
# API RESTFUL

## <span id="configuracion">CONFIGURACION</span>
* Usar un servidor apache (`xampp, lampp, laragon`) `laragon de preferencia`
* Crear una BBDD con mysql con el ARCHIVO gestion_alumnos.sql

* En el archivo `gestion_alumnos/config/conexion.php` debe editar las siguientes constantes si las necesita
```php
const HOST="localhost";
const USER="root";
const PASSWORD="";
const DATABASE="gestion_alumnos";
```

## <span id="rutas">RUTAS</span>
```
GET    /tabla
GET    /tabla/1
POST   /tabla
PUT    /tabla/1
DELETE /tabla/1
```
`SE AÑADIERON RUTAS ADICIONALES A LAS ESCRITAS PARA EL CASO PRESENTADO`

