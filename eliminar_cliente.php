<?php
require 'conexion.php';

$dpi = $_GET['dpi'] ?? null;

if (!$dpi) {
    die("DPI no proporcionado.");
}

$stmt = $pdo->prepare("DELETE FROM clientes WHERE dpi=:dpi");
$stmt->execute([':dpi' => $dpi]);

header("Location: listar_clientes.php");
exit();
