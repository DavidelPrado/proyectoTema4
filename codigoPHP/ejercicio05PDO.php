<!DOCTYPE html>
<!--David del Prado Losada
Creación: 10/11/2021
Ultima edición: 10/11/2021-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 05 PDO</title>
    </head>
    <body>
        <?php
            require_once "../config/confDBPDO.php";

            try{
                //Conectar a la base de datos
                $DAW2105DBDepartamentos = new PDO(HOST, USER, PASSWORD);
                //Cambiar el atributo ERRMODE para que muestre la excepcion en caso de error
                $DAW2105DBDepartamentos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //Comenzar transaccion
                $DAW2105DBDepartamentos->beginTransaction();
                
                //Queries de insercion
                $consulta1= <<<QUERY
                    INSERT INTO Departamento(CodDepartamento, DescDepartamento, VolumenNegocio) VALUES 
                    ('EDF', 'Departamento de Educacion Fisica', '500');
                QUERY;
                
                $consulta2= <<<QUERY
                    INSERT INTO Departamento(CodDepartamento, DescDepartamento, VolumenNegocio) VALUES 
                    ('MAT', 'Departamento de Matematicas', '3000');
                QUERY;
                    
                $consulta3= <<<QUERY
                    INSERT INTO Departamento(CodDepartamento, DescDepartamento, VolumenNegocio) VALUES 
                    ('ART', 'Departamento de Arte', '4000');
                QUERY;
                     
                //Preparar consultas
                $resultado1=$DAW2105DBDepartamentos->prepare($consulta1);
                $resultado2=$DAW2105DBDepartamentos->prepare($consulta2);
                $resultado3=$DAW2105DBDepartamentos->prepare($consulta3);
                
                //Ejecutar consultas
                $resultado1->execute();
                $resultado2->execute();
                $resultado3->execute();
                
                //Realizar commit
                $DAW2105DBDepartamentos->commit();
                
                //Query de seleccion del contenido de la tabla Departamento
                $consulta="SELECT * FROM Departamento";
                $oResultado=$DAW2105DBDepartamentos->prepare($consulta);
                $oResultado->execute();

                //Mostrar el resultado de la consulta utilizando fetchObject 
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
        ?>
    </body>
</html>