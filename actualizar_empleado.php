<?php
session_start();
require "conexion.php";

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'gerente') {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $dpi = $_POST['dpi'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $sueldo_mensual = $_POST['sueldo_mensual'];
    $rol = $_POST['rol'];

    $stmt = $pdo->prepare("UPDATE empleados 
                           SET nombres=?, apellidos=?, telefono=?, correo=?, sueldo_mensual=?, rol=? 
                           WHERE dpi=?");
    $stmt->execute([$nombres, $apellidos, $telefono, $correo, $sueldo_mensual, $rol, $dpi]);

    header("Location: gerente.php?accion=empleados");
    exit;
} else {
    header("Location: gerente.php?accion=empleados");
    exit;
}
