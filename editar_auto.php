<?php
session_start();
require "conexion.php";

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'gerente') {
    header("Location: index.php");
    exit;
}

$placa = $_GET['placa'] ?? null;
if (!$placa) {
    header("Location: gerente.php?accion=autos");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM autos WHERE placa = ?");
$stmt->execute([$placa]);
$auto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$auto) {
    echo "Auto no encontrado.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $disponible = isset($_POST['disponible']) ? 1 : 0;

    $foto = $auto['foto'];
    if (!empty($_FILES['foto']['name'])) {
        $targetDir = "uploads/autos/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $targetFile = $targetDir . basename($_FILES["foto"]["name"]);
        move_uploaded_file($_FILES["foto"]["tmp_name"], $targetFile);
        $foto = $targetFile;
    }

    $stmt = $pdo->prepare("UPDATE autos SET marca = ?, modelo = ?, disponible = ?, foto = ? WHERE placa = ?");
    $stmt->execute([$marca, $modelo, $disponible, $foto, $placa]);

    header("Location: gerente.php?accion=autos");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Auto</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h1>Editar Auto</h1>
    <form method="POST" enctype="multipart/form-data">
        Placa: <input type="text" value="<?= $auto['placa'] ?>" disabled><br>
        Marca: <input type="text" name="marca" value="<?= $auto['marca'] ?>" required><br>
        Modelo: <input type="text" name="modelo" value="<?= $auto['modelo'] ?>" required><br>
        Disponible: <input type="checkbox" name="disponible" <?= $auto['disponible'] ? 'checked' : '' ?>><br>
        Foto actual:<br>
        <?php if ($auto['foto']): ?>
            <img src="<?= $auto['foto'] ?>" width="100"><br>
        <?php else: ?>
            Sin foto<br>
        <?php endif; ?>
        Nueva foto: <input type="file" name="foto" accept="image/*"><br><br>
        <button type="submit">Guardar Cambios</button>
    </form>
</body>
</html>
