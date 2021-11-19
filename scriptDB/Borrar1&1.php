<?php
    require_once '../config/confDBPDO.php';

    try {
        //Conectar a la base de datos
        $DAW2105DBDepartamentos = new PDO(HOST, USER, PASSWORD);
        //Configurar las excepciones
        $DAW2105DBDepartamentos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $sql=<<<PDO
            drop table if exists Departamento;
        PDO;
        
        $DAW2105DBDepartamentos->exec($sql);
        
    } catch (PDOException $excepcion) {
        $errorExcepcion = $excepcion->getCode();
        $mensajeExcepcion = $excepcion->getMessage();

        //Mostrar el mensaje de la excepcion
        echo '<p>Error: ' . $mensajeExcepcion . '</p>';
        //Mostrar el codigo de la excepcion
        echo '<p>Codigo de error: ' . $errorExcepcion . '</p>';
    } finally {
        //Cerrar conexión
        unset($DAW2105DBDepartamentos);
    }
?>