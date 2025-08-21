<?php
$host = "localhost";
$db   = "renta_autos";
$user = "root";   // cambia si tienes otra config
$pass = "";       // si tu MySQL tiene contraseña ponla aquí

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}
?>
