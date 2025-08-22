<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dpi = $_POST['dpi'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];

    $sql = "INSERT INTO clientes (dpi, nombres, apellidos, telefono, correo) 
            VALUES (:dpi, :nombres, :apellidos, :telefono, :correo)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':dpi' => $dpi,
        ':nombres' => $nombres,
        ':apellidos' => $apellidos,
        ':telefono' => $telefono,
        ':correo' => $correo
    ]);

    header("Location: listar_clientes.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Cliente</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class = "container">
    <h1>Nuevo Cliente</h1>
    <form method="POST">
        <input type="text" name="dpi" placeholder="DPI" required>
        <input type="text" name="nombres" placeholder="Nombres" required>
        <input type="text" name="apellidos" placeholder="Apellidos" required>
        <input type="text" name="telefono" placeholder="Teléfono" required>
        <input type="email" name="correo" placeholder="Correo" required>
        <button type="submit">Crear Cliente</button>
    </form>
    </div>
    <a href="empleado.php">Volver</a>
    
</body>
</html>
