<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 06 PDO</title>
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
             * Created on: 10/11/2021
             * Ejercicio 6.Pagina web que cargue registros en la tabla Departamento desde un array departamentosnuevos utilizando una consulta preparada
             */
        
            echo '<h1><a href=".."><=</a>   PROYECTO TEMA 4 - EJERCICIO 6</h1>';
            
            //Incluir el archivo de conexión con la base de datos
            require_once "../config/confDBPDO.php";
            
            //Array con los datos para tres departamentos nuevos
            $aDepartamentosNuevos=[
                ["CodDepartamento"=>"CIE",
                "DescDepartamento"=>"Departamento de ciencia",
                "VolumenNegocio"=>1000],
                ["CodDepartamento"=>"REL",
                "DescDepartamento"=>"Departamento de religion",
                "VolumenNegocio"=>300],
                ["CodDepartamento"=>"DPL",
                "DescDepartamento"=>"Departamento de DPL",
                "VolumenNegocio"=>2000],
            ];
        
            try{
                //Conectar a la base de datos
                $DAW2105DBDepartamentos = new PDO(HOST, USER, PASSWORD);
                //Cambiar el atributo ERRMODE para que muestre la excepcion en caso de error
                $DAW2105DBDepartamentos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //Comenzar transaccion
                $DAW2105DBDepartamentos->beginTransaction();
                
                $consulta= <<<QUERY
                    INSERT INTO Departamento(CodDepartamento, DescDepartamento, VolumenNegocio) VALUES 
                    (:CodDepartamento, :DescDepartamento, :VolumenNegocio);
                QUERY;
                
                //Preparar consulta
                $resultado=$DAW2105DBDepartamentos->prepare($consulta);
                
                foreach($aDepartamentosNuevos as $departamento){
                    //Array con parametros para cada insert
                    $aParametros=[
                        ":CodDepartamento"=>$departamento["CodDepartamento"],
                        ":DescDepartamento"=>$departamento["DescDepartamento"],
                        ":VolumenNegocio"=>$departamento["VolumenNegocio"],
                    ];
                    
                    //Ejecutar consulta
                    $resultado->execute($aParametros);
                }

                //Realizar commit
                $DAW2105DBDepartamentos->commit();
            }catch(PDOException $excepcion){
                //Si hay un error revertir los cambios
                $DAW2105DBDepartamentos->rollBack();
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
                echo '<h2>Registros de la tabla Departamento:</h2>';
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