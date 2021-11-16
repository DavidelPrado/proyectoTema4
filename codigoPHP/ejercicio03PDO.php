<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 03 PDO</title>
        <style>
            label{
                display: block;
            }
            form{
                text-align: center;
                position: absolute;
                right: 25%;
                width: 50vw;
                margin-top: 30px;
            }
            legend{
                border: 1px solid black;
                background-color: paleturquoise;
                font-weight: bold;
            }
            fieldset{
                background-color: paleturquoise;
            }
            .opcional{
                background-color: lightgray;
            }
            p{
                color: red;
            }
            a{
                text-decoration: none;
                color: grey;
            }
            h1{
                text-align: center;
            }
            tr, td, th{
                border: 1px solid black;
            }
        </style>
    </head>
    <body>
        <?php
            /*
             * @author: David del Prado Losada
             * @version: v1.Realizacion del ejercicio
             * Created on: 08/11/2021
             * Ejercicio 3.Formulario para añadir un departamento a la tabla Departamento con validación de entrada y control de errores
             */
        
            echo '<h1><a href=".."><=</a>   PROYECTO TEMA 4 - EJERCICIO 3</h1>';
            
            //Incluir la libreria de validación de formularios
            require_once '../core/210322ValidacionFormularios.php';
            
            //Incluir el archivo de conexión con la base de datos
            require_once "../config/confDBPDO.php";
        
            //Definir constantes
            define("OBLIGATORIO", 1);
            define("OPCIONAL", 0);
            define("MIN_TAMANIO", 1);
            
            //Definir array para almacenar errores
            $aErrores=[
                "codDep"=>null,
                "descripcion"=>null,
                "volumen"=>null,
            ];
            
            //Definir array para almacenar respuestas correctas
            $aCorrecto=[
                "codDep"=>null,
                "descripcion"=>null,
                "volumen"=>null,
            ];
            
            //Inicializar variable que controlara si los campos estan correctos
            $entradaOK=true;
            
            //Comprobar si se ha pulsado el boton de enviar
            if(isset($_REQUEST['enviar'])){
                //Comprobar si los campos son correctos
                $aErrores["codDep"]=validacionFormularios::comprobarAlfabetico($_REQUEST["codDep"], 3, 3, OBLIGATORIO);
                $aErrores["descripcion"]=validacionFormularios::comprobarAlfaNumerico($_REQUEST["descripcion"], 255, MIN_TAMANIO, OBLIGATORIO);
                $aErrores["volumen"]=validacionFormularios::comprobarFloat($_REQUEST["volumen"], 10000, 0, OBLIGATORIO);
 
                //Comprobar que el codDep no esta repetido
                if($aErrores['codDep']==null){
                    try{
                        //Conectar a la base de datos
                        $DAW2105DBDepartamentos = new PDO(HOST, USER, PASSWORD);
                        //Configurar las excepciones
                        $DAW2105DBDepartamentos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        //Query de seleccion que comprueba que CodDep no esta repetido
                        $consulta="SELECT CodDepartamento FROM Departamento WHERE CodDepartamento='{$_REQUEST['codDep']}'";
                        $oResultado=$DAW2105DBDepartamentos->prepare($consulta);
                        $oResultado->execute();
                        
                        //Compruebar que el resultado de la consulta es mayor que 0, si es mayor que 0 el codigo de departamento ya existe
                        if($oResultado->rowCount()>0){
                            $aErrores['codDep']="El codigo de departamento introducido ya existe.";
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
                }
                    
                //Recorrer el array de errores para comprobar si hay algun error en el formulario
                foreach($aErrores as $nombreCampo=>$valor){
                    if($valor!=null){
                        $_REQUEST[$nombreCampo]="";//Si encuentra un error vacia el campo
                        $entradaOK=false;//Si se encuentra algun error se cambia la variable entradaOK a false
                    }
                }
                
            }else{
                //El formulario no se ha rellenado nunca
                $entradaOK=false;
            }
            
            
            //Comprobar si la entrada es correcta
            if($entradaOK){
                try{
                    //Almacenar las respuestas correctas en el array $aCorrecto
                    $aCorrecto=[
                        "codDep"=>$_REQUEST["codDep"],
                        "descripcion"=>$_REQUEST["descripcion"],
                        "volumen"=>$_REQUEST["volumen"],
                    ];
                
                    //Conectar a la base de datos
                    $DAW2105DBDepartamentos = new PDO(HOST, USER, PASSWORD);
                    //Configurar las excepciones
                    $DAW2105DBDepartamentos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    //Query de la insercion
                    $consulta= <<<QUERY
                            INSERT INTO Departamento(CodDepartamento, DescDepartamento, VolumenNegocio) VALUES 
                            ('{$aCorrecto['codDep']}', '{$aCorrecto['descripcion']}', {$aCorrecto['volumen']});
                    QUERY;
                    
                    $oResultado=$DAW2105DBDepartamentos->exec($consulta);
                    
                    //Query de seleccion del contenido de la tabla Departamento
                    $consulta2="SELECT * FROM Departamento";
                    $oResultado2=$DAW2105DBDepartamentos->prepare($consulta2);
                    $oResultado2->execute();

                    //Mostrar el resultado de la consulta utilizando fetchObject 
                    $oDepartamento=$oResultado2->fetchObject();

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
                        $oDepartamento=$oResultado2->fetchObject();
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
                
            }else{
                //Mostrar el fomulario
        ?>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method='post'>
                <fieldset>
                    <legend>Nuevo departamento:</legend>
                    
                    <label>Codigo departamento: *</label>
                    <input type='text' name='codDep' value="<?php
                        //Mostrar los datos correctos introducidos en un intento anterior
                        echo isset($_REQUEST["codDep"]) ? $_REQUEST["codDep"] : "";
                    ?>"/><p><?php
                        //Mostrar los errores en el codigo, si los hay
                        echo $aErrores["codDep"]!=null ? $aErrores["codDep"] : "";
                    ?></p>
                    
                    <label>Descripcion: *</label>
                    <input type='text' name='descripcion' value="<?php
                        //Mostrar los datos correctos introducidos en un intento anterior
                        echo isset($_REQUEST["descripcion"]) ? $_REQUEST["descripcion"] : "";
                    ?>"/><p ><?php
                        //Mostrar los errores en la descripcion, si los hay
                        echo $aErrores["descripcion"]!=null ? $aErrores["descripcion"] : "";
                    ?></p>
                    
                    <label>Volumen: *</label>
                    <input type='text' name='volumen' value="<?php
                        //Mostrar los datos correctos introducidos en un intento anterior
                        echo isset($_REQUEST["volumen"]) ? $_REQUEST["volumen"] : "";
                    ?>"/><p><?php
                        //Mostrar los errores en el volumen, si los hay
                        echo $aErrores["volumen"]!=null ? $aErrores["volumen"] : "";
                    ?></p>
                    <br>
                    <input type='submit' name='enviar' value='Enviar'/>
                </fieldset>
            </form>
        <?php    
            } 
        ?>
    </body>
</html>

