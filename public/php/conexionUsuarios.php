<?php
    // set up the connection variables
    $database  = 'Usuarios';
    $hostname = '127.0.0.1';
    $password = 'audiovisual';
    $username = 'lais';
    
    try {
        $conex = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
        $conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Para manejo de errores con PDO
        $conex->exec("SET NAMES utf8"); // Permite mostrar los resultados con acentos y caracteres extraños
    }
    catch(PDOException $e) {
        echo "I'm sorry, Dave. I'm afraid I can't do that.<br>"; // :)
        echo "Error: " . $e->getMessage();
    }
?>