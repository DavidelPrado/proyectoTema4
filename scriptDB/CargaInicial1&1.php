<?php
    require_once '../config/confDBPDO.php';

    try {
        //Conectar a la base de datos
        $DAW2105DBDepartamentos = new PDO(HOST, USER, PASSWORD);
        //Configurar las excepciones
        $DAW2105DBDepartamentos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $sql=<<<PDO
            INSERT INTO Departamento (CodDepartamento, DescDepartamento, FechaBaja, VolumenNegocio) VALUES 
            ('INF', 'Departamento de informatica', null, 1000.0),
            ('CIE', 'Departamento de ciencia', null, 2000.0),
            ('HIS', 'Departamento de historia', null, 1000.0);
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