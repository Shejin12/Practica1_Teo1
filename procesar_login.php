<?php
session_start();
require "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $passwrd  = $_POST["passwrd"];

    $sql = "SELECT dpi, rol, passwrd FROM empleados WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["username" => $username]);
    $empleado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($empleado && $passwrd === $empleado["passwrd"]) {
        $_SESSION["usuario"] = $empleado["dpi"];
        $_SESSION["rol"]     = $empleado["rol"];

        switch ($empleado["rol"]) {
            case "gerente":
                header("Location: gerente.php");
                break;
            case "limpieza":
                header("Location: limpieza.php");
                break;
            case "atencion":
                header("Location: empleado.php");
                break;
            default:
                echo "Rol no reconocido.";
        }
        exit;
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
}
?>