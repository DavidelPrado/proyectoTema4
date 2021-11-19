<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Muestra Configuracion PDO</title>
    </head>
    <body>
        <?php
            echo "<h1>Configuración en PDO:</h1>";
            highlight_file("../config/confDBPDO.php");
            
            echo "<h1>Configuración en MySQL:</h1>";
            highlight_file("../config/confDBMySQL.php");
        ?>
    </body>
</html>