<!DOCTYPE html>
<!--David del Prado Losada
Creación: 04/11/2021
Ultima edición: 05/11/2021-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 01 MySQLi</title>
    </head>
    <body>
        <?php
            //Incluir el archivo de conexión con la base de datos
            include "../config/confDBMySQL.php";
        
            //Instanciar objeto mysql
            $DAW2105DBDepartamentos=new mysqli();
             
            //Realizar conexión a la base de datos
            $DAW2105DBDepartamentos->connect(HOST, USER, PASSWORD, DB);
            
            //Obtener errores de la conexión
            $error=$DAW2105DBDepartamentos->connect_errno;
            
            //Mostrar errores
            print_r("Errores: ".$error);
            
            //Cerrar conexión
            $DAW2105DBDepartamentos->close();
        ?>
    </body>
</html>

