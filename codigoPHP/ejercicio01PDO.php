<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 01 PDO</title>
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
            require_once "../config/confDBPDO.php";

            echo '<h2>Parametros correctos: </h2>';
            try{
                //Conectar a la base de datos
                $DAW2105DBDepartamentos = new PDO(HOST, USER, PASSWORD);
                //Cambiar el atributo ERRMODE para que muestre la excepcion en caso de error
                $DAW2105DBDepartamentos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                //Array con los atributos de PDO
                $attributes = array(
                    "AUTOCOMMIT", 
                    "ERRMODE", 
                    "CASE", 
                    "CLIENT_VERSION", 
                    "CONNECTION_STATUS",
                    "ORACLE_NULLS", 
                    "PERSISTENT", 
                    "SERVER_INFO", 
                    "SERVER_VERSION"
                );

                //Recorrer el array y mostrar los valores
                foreach ($attributes as $val) {
                    echo "PDO::ATTR_".$val.": ".$DAW2105DBDepartamentos->getAttribute(constant("PDO::ATTR_$val"))."<br>";
                }
            }catch(PDOException $excepcion){
                $errorExcepcion=$excepcion->getCode();
                $mensajeExcepcion=$excepcion->getMessage();
                
                //Mostrar el mensaje de la excepcion
                echo '<p>Error: '.$mensajeExcepcion.'</p>';
                //Mostrar el codigo de la excepcion
                echo '<p>Codigo de error: '.$errorExcepcion.'</p>';
            }finally{
                //Cerrar conexión
                unset($DAW2105DBDepartamentos);
            }
            
            
            //Probar que la excepcion funciona insertando una contraseña incorrecta
            echo '<h2>Constraseña incorrecta: </h2>';
            try{
                //Conectar a la base de datos
                $DAW2105DBDepartamentos = new PDO(HOST, USER, "paso");
                //Cambiar el atributo ERRMODE para que muestre la excepcion en caso de error
                $DAW2105DBDepartamentos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                //Array con los atributos de PDO
                $attributes = array(
                    "AUTOCOMMIT", 
                    "ERRMODE", 
                    "CASE", 
                    "CLIENT_VERSION", 
                    "CONNECTION_STATUS",
                    "ORACLE_NULLS", 
                    "PERSISTENT", 
                    "SERVER_INFO", 
                    "SERVER_VERSION"
                );

                //Recorrer el array y mostrar los valores
                foreach ($attributes as $val) {
                    echo "PDO::ATTR_".$val.": ".$DAW2105DBDepartamentos->getAttribute(constant("PDO::ATTR_$val"))."<br>";
                }
            }catch(PDOException $excepcion){
                $errorExcepcion=$excepcion->getCode();
                $mensajeExcepcion=$excepcion->getMessage();
                
                //Mostrar el mensaje de la excepcion
                echo '<p>Error: '.$mensajeExcepcion.'</p>';
                //Mostrar el codigo de la excepcion
                echo '<p>Codigo de error: '.$errorExcepcion.'</p>';
            }finally{
                //Cerrar conexión
                unset($DAW2105DBDepartamentos);
            }
        ?>
    </body>
</html>

