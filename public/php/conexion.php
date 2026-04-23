<?php

    // set up the connection variables
    $database  = getenv('DB_NAME');
    $hostname = getenv('DB_HOST');
    $password = getenv('DB_PASS');
    $username = getenv('DB_USER');

    try {
        $conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Para manejo de errores con PDO
        $conn->exec("SET NAMES utf8"); // Permite mostrar los resultados con acentos y caracteres extraños
    }
    catch(PDOException $e) {
        echo "I'm sorry, Dave. I'm afraid I can't do that.<br>"; // :)
        echo "Error: " . $e->getMessage();
    }

?>