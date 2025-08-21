<?php
session_start();
require "conexion.php";

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'gerente') {
    header("Location: index.php");
    exit;
}

if (isset($_GET['dpi'])) {
    $dpi = $_GET['dpi'];

    $stmt = $pdo->prepare("DELETE FROM empleados WHERE dpi = ?");
    $stmt->execute([$dpi]);

    header("Location: gerente.php?msg=empleado_eliminado");
    exit;
} else {
    header("Location: gerente.php");
    exit;
}