<?php
session_start();
require "conexion.php";

if (isset($_GET['logout'])) {
    session_destroy(); 
    header("Location: index.php");
    exit;
}

if (isset($_SESSION['rol'])) {
    switch ($_SESSION['rol']) {
        case 'gerente':
            header("Location: gerente.php");
            exit;
        case 'limpieza':
            header("Location: limpieza.php");
            exit;
        case 'atencion':
            header("Location: empleado.php");
            exit;
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistema de Renta de Autos</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
    <h2>Iniciar Sesión</h2>
    <form action="procesar_login.php" method="POST">
        <label>Usuario:</label>
        <input type="text" name="username" required><br><br>

        <label>Contraseña:</label>
        <input type="password" name="passwrd" required><br><br>

        <button type="submit">Ingresar</button>
    </form>
    </div>
</body>
</html>