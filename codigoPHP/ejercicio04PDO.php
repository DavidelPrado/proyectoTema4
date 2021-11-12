<!DOCTYPE html>
<!--David del Prado Losada
Creación: 10/11/2021
Ultima edición: 10/11/2021-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 04 PDO</title>
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
        </style>
    </head>
    <body>
        <?php
            //Incluir la libreria de validación de formularios
            include '../core/210322ValidacionFormularios.php';
            
            //Incluir el archivo de conexión con la base de datos
            include "../config/confDBPDO.php";
        
            //Definir constantes
            define("OBLIGATORIO", 1);
            define("OPCIONAL", 0);
            define("MIN_TAMANIO", 1);
            
            //Definir array para almacenar errores
            $aErrores=[
                "descripcion"=>null,
            ];
            
            //Definir array para almacenar respuestas correctas
            $aCorrecto=[
                "descripcion"=>null,
            ];
            
            //Inicializar variable que controlara si los campos estan correctos
            $entradaOK=true;
            
            //Comprobar si se ha pulsado el boton de enviar
            if(isset($_REQUEST['enviar'])){
                //Comprobar si los campos son correctos
                $aErrores["descripcion"]=validacionFormularios::comprobarAlfaNumerico($_REQUEST["descripcion"], 255, MIN_TAMANIO, OPCIONAL); 
                
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
                        "descripcion"=>$_REQUEST["descripcion"],
                    ];
                
                    //Conectar a la base de datos
                    $DAW2105DBDepartamentos = new PDO(HOST, USER, PASSWORD);
                    //Configurar las excepciones
                    $DAW2105DBDepartamentos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    //Query de seleccion que comprueba que CodDep no esta repetido
                    $consulta="SELECT * FROM Departamento WHERE DescDepartamento like'%{$_REQUEST['descripcion']}%';";
                    $oResultado=$DAW2105DBDepartamentos->prepare($consulta);
                    $oResultado->execute();
                        
                    //Compruebar que el resultado de la consulta es mayor que 0, si es mayor que 0 el codigo de departamento ya existe
                    if($oResultado->rowCount()>0){
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
                
            }else{
                //Mostrar el fomulario
        ?>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method='post'>
                <fieldset>
                    <legend>Buscar departamento por descripción:</legend>
                    <label>Descripción:</label>
                    <input type='text' name='descripcion' value="<?php
                        //Mostrar los datos correctos introducidos en un intento anterior
                        echo isset($_REQUEST["descripcion"]) ? $_REQUEST["descripcion"] : "";
                    ?>"/><p ><?php
                        //Mostrar los errores en la descripcion, si los hay
                        echo $aErrores["descripcion"]!=null ? $aErrores["descripcion"] : "";
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

