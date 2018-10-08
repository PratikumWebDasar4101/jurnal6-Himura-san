<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db   = "db_tugas";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e){
        print("Koneksi bermasalah : " . $e -> getMessage() . "<br>");
    }
?>