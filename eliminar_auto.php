<?php
session_start();
require "conexion.php";

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'gerente') {
    header("Location: index.php");
    exit;
}

$placa = $_GET['placa'] ?? null;
if ($placa) {
    $stmt = $pdo->prepare("DELETE FROM autos WHERE placa = ?");
    $stmt->execute([$placa]);
}

header("Location: gerente.php?accion=autos");
exit;
