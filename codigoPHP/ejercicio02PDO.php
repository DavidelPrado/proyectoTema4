<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 02 PDO</title>
        <style>
            tr, th, td{
                border: 1px solid black;
            }
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
             * Created on: 08/11/2021
             * Ejercicio 2.Mostrar el contenido de la tabla Departamento y el número de registros.
             */
        
            echo '<h1><a href=".."><=</a>   PROYECTO TEMA 4 - EJERCICIO 2</h1>';
            
            //Incluir el archivo de conexión con la base de datos
            include "../config/confDBPDO.php";

            try{
                //Conectar a la base de datos
                $DAW2105DBDepartamentos = new PDO(HOST, USER, PASSWORD);
                //Configurar las excepciones
                $DAW2105DBDepartamentos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                //Query de seleccion del contenido de la tabla Departamento
                $consulta="SELECT * FROM Departamento";
                $oResultado=$DAW2105DBDepartamentos->prepare($consulta);
                $oResultado->execute();
                
                //Mostrar el resultado de la consulta utilizando fetchObject 
                echo '<h2>Registros de la tabla Departamento con fetchObject:</h2>';
                $oDepartamento=$oResultado->fetchObject();
                
                echo '<table>';
                echo '<tr>';
                echo '<th>CodDepartamento</th>';
                echo '<th>DescDepartamento</th>';
                echo '<th>FechaBaja</th>';
                echo '<th>VolumenNegocio</th>';
                echo '</tr>';
                while($oDepartamento){
                    echo '<tr>';
                    foreach ($oDepartamento as $valor) {
                        echo "<td>$valor</td>";
                    }
                    echo '</tr>';
                    $oDepartamento=$oResultado->fetchObject();
                }
                echo '</table>';
                
                //Devolver numero de registros
                
                /*
                $oResultado->execute();
                //Mostrar el resultado de la consulta utilizando fetch
                echo '<h2>Registros de la tabla Departamento con fetch:</h2>';
                $oDepartamento=$oResultado->fetch(PDO::FETCH_OBJ);
                echo '<table>';
                while($oDepartamento){
                    echo '<tr>';
                    foreach ($oDepartamento as $valor) {
                        echo "<td>$valor</td>";
                    }
                    echo '</tr>';
                    $oDepartamento=$oResultado->fetch(PDO::FETCH_OBJ);
                }
                echo '</table>';
                
                $oResultado->execute();
                //Mostrar el resultado de la consulta utilizando fetchAll
                echo '<h2>Registros de la tabla Departamento con fetchAll:</h2>';
                $oDepartamento=$oResultado->fetchAll(PDO::FETCH_OBJ);
                echo '<table>';
                foreach ($oDepartamento as $aFila) {
                    echo '<tr>';
                    foreach ($aFila as $valor) {
                        echo "<td>$valor</td>";
                    }
                    echo '</tr>';
                    }
                echo '</table>';
                */
                
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

