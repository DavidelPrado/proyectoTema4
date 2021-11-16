<!DOCTYPE html>
<!--David del Prado Losada
Creación: 11/11/2021
Ultima edición: 15/11/2021-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 07 PDO XML</title>
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
             * Created on: 11/11/2021
             * Ejercicio 7.Página web que toma datos (código y descripción) de un fichero xml y los 
             * añade a la tabla Departamento de nuestra base de datos. (IMPORTAR). El fichero importado 
             * se encuentra en el directorio .../tmp/ del servidor.
             */
        
            echo '<h1><a href=".."><=</a>   PROYECTO TEMA 4 - EJERCICIO 7</h1>';
            
            //Incluir el archivo de conexión con la base de datos
            require_once "../config/confDBPDO.php";
        
            try{
                //Conectar a la base de datos
                $DAW2105DBDepartamentos = new PDO(HOST, USER, PASSWORD);
                //Cambiar el atributo ERRMODE para que muestre la excepcion en caso de error
                $DAW2105DBDepartamentos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                //Query de inserccion de datos en la tabla Departamento
                $consulta="INSERT INTO Departamento VALUES (:CodDepartamento, :DescDepartamento, :FechaBaja, :VolumenNegocio);";
                $oResultado=$DAW2105DBDepartamentos->prepare($consulta);
                
                //Formateo de la salida
                $archivoXML=new DOMDocument();
                $archivoXML->formatOutput=true;
                
                //Carga del archivo
                $archivoXML->load("../tmp/departamento.xml");
                
                //Seleccion de la raiz
                $departamentos=$archivoXML->getElementsByTagName('Departamentos');
                
                //Elemento departamento
                $departamento=$archivoXML->getElementsByTagName('Departamento');
                
                foreach($departamento as $datoDepartamento){
                    //Datos de cada departamento
                    $codDepartamento=$datoDepartamento->getElementsByTagName('CodDepartamento')->item(0)->nodeValue;
                    $descDepartamento=$datoDepartamento->getElementsByTagName('DescDepartamento')->item(0)->nodeValue;
                    $fechaBaja=$datoDepartamento->getElementsByTagName('FechaBaja')->item(0)->nodeValue==''?null:$FechaBaja;
                    $volumenNegocio=$datoDepartamento->getElementsByTagName('VolumenNegocio')->item(0)->nodeValue;
                    
                    $oResultado->bindParam(':CodDepartamento', $codDepartamento);
                    $oResultado->bindParam(':DescDepartamento', $descDepartamento);
                    $oResultado->bindParam(':FechaBaja', $fechaBaja);
                    $oResultado->bindParam(':VolumenNegocio', $volumenNegocio);
                    
                    //Ejecutar consulta
                    $oResultado->execute();
                }
                
                echo 'Datos importados';
                
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