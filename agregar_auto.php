<?php
session_start();
require "conexion.php";

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'gerente') {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $placa = $_POST['placa'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $disponible = isset($_POST['disponible']) ? 1 : 0;

    // Manejo de foto
    $foto = null;
    if (!empty($_FILES['foto']['name'])) {
        $targetDir = "uploads/autos/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $targetFile = $targetDir . basename($_FILES["foto"]["name"]);
        move_uploaded_file($_FILES["foto"]["tmp_name"], $targetFile);
        $foto = $targetFile;
    }

    $stmt = $pdo->prepare("INSERT INTO autos (placa, marca, modelo, disponible, foto) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$placa, $marca, $modelo, $disponible, $foto]);

    header("Location: gerente.php?accion=autos");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Auto</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h1>Agregar Auto</h1>
    <form method="POST" enctype="multipart/form-data">
        Placa: <input type="text" name="placa" maxlength="7" required><br>
        Marca: <input type="text" name="marca" required><br>
        Modelo: <input type="text" name="modelo" required><br>
        Disponible: <input type="checkbox" name="disponible" checked><br>
        Foto: <input type="file" name="foto" accept="image/*"><br><br>
        <button type="submit">Guardar</button>
    </form>
</body>
</html>
