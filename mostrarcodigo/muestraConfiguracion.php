<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Muestra Configuracion PDO</title>
    </head>
    <body>
        <?php
            echo '<h2>CONFIGURACION EN PDO</h2>';
            highlight_file("../config/confDBPDO.php");
            
            echo '<h2>CONFIGURACION EN MySQL</h2>';
            highlight_file("../config/confDBMySQL.php");
        ?>
    </body>
</html>