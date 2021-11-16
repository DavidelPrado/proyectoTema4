<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 08 PDO XML</title>
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
                
                //Formateo de la salida
                $archivoXML=new DOMDocument();
                $archivoXML->formatOutput=true;
                
                //Creacion de la raiz
                $departamentos=$archivoXML->createElement('Departamentos');
                $root=$archivoXML->appendChild($departamentos);
                
                $oDepartamento=$oResultado->fetchObject();
                while($oDepartamento){
                    //Elemento departamento
                    $departamento=$archivoXML->createElement('Departamento');
                    $departamentos->appendChild($departamento);
                    
                    //Datos de cada departamento
                    $datosDepartamento=$archivoXML->createElement('CodDepartamento', $oDepartamento->CodDepartamento);
                    $departamento->appendChild($datosDepartamento);
                    
                    $datosDepartamento=$archivoXML->createElement('DescDepartamento', $oDepartamento->DescDepartamento);
                    $departamento->appendChild($datosDepartamento);
                    
                    $datosDepartamento=$archivoXML->createElement('FechaBaja', $oDepartamento->FechaBaja);
                    $departamento->appendChild($datosDepartamento);
                    
                    $datosDepartamento=$archivoXML->createElement('VolumenNegocio', $oDepartamento->VolumenNegocio);
                    $departamento->appendChild($datosDepartamento);
                    
                    $oDepartamento=$oResultado->fetchObject();
                }
                
                //Guardado del archivo
                $archivoXML->save("../tmp/departamento.xml");
                
                //Mostrar cantidad de bytes escritos
                echo '<div>Se han escrito '.$archivoXML->save('../tmp/departamento.xml').' bytes</div>';
                
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