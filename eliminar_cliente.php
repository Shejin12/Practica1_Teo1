<?php
include("conexion.php");
session_start();

if (isset($_GET['dpi'])) {
    $dpi = $_GET['dpi'];

    $stmt = $conn->prepare("DELETE FROM clientes WHERE dpi = ?");
    $stmt->bind_param("s", $dpi);

    if ($stmt->execute()) {
        header("Location: listar_clientes.php");
        exit();
    } else {
        echo "Error al eliminar cliente: " . $conn->error;
    }
} else {
    header("Location: listar_clientes.php");
    exit();
}
