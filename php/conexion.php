<?php
$host = "localhost";
$port = "5432";
$dbname = "posgrado_Feca";
$user = "postgres";
$password = "Owen1234";

try {
    $conexion = new PDO(
        "pgsql:host=$host;port=$port;dbname=$dbname",
        $user,
        $password
    );

    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexion->exec("SET NAMES 'UTF8'");
} catch (PDOException $e) {
    die("Error de conexion: " . $e->getMessage());
}
?>
