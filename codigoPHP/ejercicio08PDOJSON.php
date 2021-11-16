<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 08 PDO JSON</title>
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
             * Ejercicio 8.Página web que toma datos (código y descripción) de la tabla Departamento y guarda en un fichero departamento.xml. (COPIA DE SEGURIDAD / EXPORTAR). El fichero exportado se encuentra en el directorio .../tmp/ del servidor.
             */
        
            echo '<h1><a href=".."><=</a>   PROYECTO TEMA 4 - EJERCICIO 8</h1>';
            
            //Incluir el archivo de conexión con la base de datos
            require_once "../config/confDBPDO.php";
        
            try{
                //Conectar a la base de datos
                $DAW2105DBDepartamentos = new PDO(HOST, USER, PASSWORD);
                //Cambiar el atributo ERRMODE para que muestre la excepcion en caso de error
                $DAW2105DBDepartamentos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                
                //Query de seleccion del contenido de la tabla Departamento
                $consulta="SELECT * FROM Departamento";
                $oResultado=$DAW2105DBDepartamentos->prepare($consulta);
                $oResultado->execute();
                
                $aDepartamentos=[];
                
                $departamento=$oResultado->fetchObject();
                while($departamento){
                    $aDepartamento=[
                        "CodDepartamento"=>$departamento->CodDepartamento,
                        "DescDepartamento"=>$departamento->DescDepartamento,
                        "FechaBaja"=>$departamento->FechaBaja,
                        "VolumenNegocio"=>$departamento->VolumenNegocio,
                    ];
                    
                    array_push($aDepartamentos, $aDepartamento);
                    $departamento=$oResultado->fetchObject();
                }
                
                
                $archivoJSON=json_encode($aDepartamentos, JSON_PRETTY_PRINT);
                
                file_put_contents("../tmp/departamento.json", $archivoJSON);
                
                echo 'Archivo creado';
                
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