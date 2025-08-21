<?php
include("conexion.php");
session_start();

if (!isset($_GET['dpi'])) {
    header("Location: listar_clientes.php");
    exit();
}

$dpi = $_GET['dpi'];
$res = $conn->query("SELECT * FROM clientes WHERE dpi = '$dpi'");
$cliente = $res->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];

    $stmt = $conn->prepare("UPDATE clientes SET nombres=?, apellidos=?, telefono=?, correo=? WHERE dpi=?");
    $stmt->bind_param("sssss", $nombres, $apellidos, $telefono, $correo, $dpi);

    if ($stmt->execute()) {
        header("Location: listar_clientes.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<div class="container">
    <h2>Editar Cliente</h2>
    <form method="POST">
        <input type="text" name="nombres" value="<?= $cliente['nombres'] ?>" required>
        <input type="text" name="apellidos" value="<?= $cliente['apellidos'] ?>" required>
        <input type="text" name="telefono" value="<?= $cliente['telefono'] ?>" required>
        <input type="email" name="correo" value="<?= $cliente['correo'] ?>">
        <input type="submit" value="Actualizar">
    </form>
</div>
