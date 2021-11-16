<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 07 PDO JSON</title>
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
             * Created on: 16/11/2021
             * Ejercicio 7.Página web que toma datos (código y descripción) de un fichero xml y los añade 
             * a la tabla Departamento de nuestra base de datos. (IMPORTAR). El fichero importado se 
             * encuentra en el directorio .../tmp/ del servidor.
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
                
                //Obtener contenido del archivo departamento.json
                $archivoJSON=file_get_contents("../tmp/departamento.json");
                
                //Transforma el archivo a un formato que php pueda utilizar
                $aDepartamentos=json_decode($archivoJSON);
                
                //Datos de cada departamento
                foreach($aDepartamentos as $departamento){
                    $oResultado->bindParam(':CodDepartamento', $departamento->CodDepartamento);
                    $oResultado->bindParam(':DescDepartamento', $departamento->DescDepartamento);
                    $oResultado->bindParam(':FechaBaja', $departamento->FechaBaja);
                    $oResultado->bindParam(':VolumenNegocio', $departamento->VolumenNegocio);
                    
                    //Ejecutar el query
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