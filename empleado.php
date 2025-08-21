<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'atencion') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Empleado</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="container">
    <p>Bienvenido, 
    <?php 
        $nombre = $_SESSION['nombres'] ?? $_SESSION['username'] ?? 'Empleado';
        echo htmlspecialchars($nombre);
    ?> </p>

    <a href="listar_clientes.php">Listado de Clientes</a>
    <a href="agregar_cliente.php">Agregar Cliente</a>
    <a href="crear_alquiler.php">Nuevo Alquiler</a>
    <a href="listar_alquileres.php">Listar Alquileres</a>
    <a href="listar_autos.php">Listado de Autos</a>
    <a href="index.php?logout=1.php">Cerrar Sesión</a>
</div>
</body>
</html>
