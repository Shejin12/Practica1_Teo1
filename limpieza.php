<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'limpieza') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Empleado de Limpieza</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

</body>
</html>
