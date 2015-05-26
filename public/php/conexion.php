<?php

        // set up the connection variables
        $db_name  = 'mundo';
        $hostname = '127.0.0.1';
        $password = 'djrashad1992';
        $username = 'root';

        // connect to the database
        $dbh = new PDO("mysql:host=$hostname;dbname=$db_name", $username, $password);
        $dbh->exec("SET NAMES utf-8");

        // a query get all the records from the users table
        $sql = 'SELECT * FROM paises';

        // use prepared statements, even if not strictly required is good practice
        $stmt = $dbh->prepare( $sql );

        // execute the query
        $stmt->execute();

        // fetch the results into an array
        $result = $stmt->fetch( PDO::FETCH_ASSOC);

        echo print_r($result);
        
        $json = json_encode($result);
        echo $json;

?>