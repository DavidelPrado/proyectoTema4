<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 01 MySQLi</title>
        <style>
            a{
                text-decoration: none;
                color: grey;
            }
            h1{
                text-align: center;
            }
        </style>
    </head>
    <body>
        <?php
            /*
             * @author: David del Prado Losada
             * @version: v1.Realizacion del ejercicio
             * Created on: 04/1/2021
             * Ejercicio 1.Conexión a la base de datos con la cuenta usuario y tratamiento de errores.
             */
        
            echo '<h1><a href=".."><=</a>   PROYECTO TEMA 4 - EJERCICIO 1</h1>';
            
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

