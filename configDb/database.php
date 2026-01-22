<?php 

    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "biblio";

    try {
        $connection = new PDO(
            "mysql:host=$hostname;dbname=$database",
            $username,
            $password
        );
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo "Error: " . $e;
        }



?>