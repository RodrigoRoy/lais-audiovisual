<!DOCTYPE html>
<html>
    <body>
    <head>
        <title>Portadas de la colección audiovisual</title>

        <meta charset="utf-8"> <!-- Codificación de la página (permite acentos) -->
        <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Para uso de diseño responsivo con Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </head>

    <div class="container">
    	<h1>Portadas de la colección de documentales del LAIS</h1>
    	
        <table class="table table-hover">
            <?php
                $dir    = '.';
                $files = scandir($dir);
                foreach ($files as $key => $file) {
                    if(preg_match("/.*\.(jpg|png)$/i", $file, $matches)){
                        echo "<tr>";
                        echo   "<td>";
                        echo     "<strong><samp>$file</samp></strong>";
                        echo     '<img src="' . $file .  '" class="img-responsive" width="400">';
                        echo   "</td>";
                        echo "</tr>";
                    }
                }
            ?>
        </table>
    </div>

    </body>
</html>