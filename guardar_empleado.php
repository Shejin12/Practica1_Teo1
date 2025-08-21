<?php
require "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "INSERT INTO empleados (dpi, rol, nombres, apellidos, telefono, correo, sueldo_mensual, username, passwrd)
            VALUES (:dpi, :rol, :nombres, :apellidos, :telefono, :correo, :sueldo, :username, :passwrd)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":dpi"      => $_POST["dpi"],
        ":rol"      => $_POST["rol"],
        ":nombres"  => $_POST["nombres"],
        ":apellidos"=> $_POST["apellidos"],
        ":telefono" => $_POST["telefono"],
        ":correo"   => $_POST["correo"],
        ":sueldo"   => $_POST["sueldo"],
        ":username" => $_POST["username"],
        ":passwrd"  => $_POST["passwrd"]  // ⚠ En producción, usar password_hash()
    ]);
    header("Location: gerente.php");
}
?>