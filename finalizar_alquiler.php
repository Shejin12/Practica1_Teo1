<?php
include("conexion.php");
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $res = $conn->query("SELECT * FROM alquileres WHERE id_alquiler = $id");
    $alq = $res->fetch_assoc();

    $hora_real = date("Y-m-d H:i:s");
    $hora_estimada = strtotime($alq['hora_llegada']);
    $hora_real_int = strtotime($hora_real);

    $extra = 0;
    if ($hora_real_int > $hora_estimada) {
        $horas_extra = ceil(($hora_real_int - $hora_estimada) / 3600);
        $extra = $horas_extra * 30;
    }

    $total_final = $alq['total_cobrado'] + $extra;

    // actualizar alquiler
    $stmt = $conn->prepare("UPDATE alquileres SET hora_llegada=?, total_cobrado=? WHERE id_alquiler=?");
    $stmt->bind_param("sdi", $hora_real, $total_final, $id);
    $stmt->execute();

    // liberar auto
    $conn->query("UPDATE autos SET disponible = 1 WHERE placa = '{$alq['placa_auto']}'");

    header("Location: listar_alquileres.php");
    exit();
}
