<!DOCTYPE html>
<!--David del Prado Losada
Creación: 11/11/2021
Ultima edición: 11/11/2021-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 08 PDO</title>
    </head>
    <body>
        <?php
            //Incluir el archivo de conexión con la base de datos
            require_once "../config/confDBPDO.php";
        
            try{
                //Conectar a la base de datos
                $DAW2105DBDepartamentos = new PDO(HOST, USER, PASSWORD);
                //Cambiar el atributo ERRMODE para que muestre la excepcion en caso de error
                $DAW2105DBDepartamentos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                
                //Query de seleccion del contenido de la tabla Departamento
                $consulta="SELECT CodDepartamento, DescDepartamento FROM Departamento";
                $oResultado=$DAW2105DBDepartamentos->prepare($consulta);
                $oResultado->execute();
                
                $archivoXML=new DOMDocument("1.0", "UTF-8");
                $archivoXML->formatOutput=true;
                
                
                $nodo=$archivoXML->createElement('Departamentos');
                $root=$archivoXML->appendChild($nodo);
                
                $oDepartamento=$oResultado->fetchObject();
                while($oDepartamento){
                    $nodo=$archivoXML->createElement('Departamento');
                    $root=$archivoXML->appendChild($nodo);
                    
                    $oDepartamento=$consulta->fetchObject();
                }
                
                $archivoXML->save("../tmp/departamento.xml");
                
                
                
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