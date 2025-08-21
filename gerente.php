<?php
session_start();
require "conexion.php";

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'gerente') {
    header("Location: index.php");
    exit;
}

$accion = $_GET['accion'] ?? 'inicio';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Gerente</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
    <h1>Panel del Gerente</h1>

    <a href="gerente.php?accion=listar_alquileres">Listado de Alquileres</a> |
    <a href="gerente.php?accion=reporte">Reporte Financiero</a> |
    <a href="gerente.php?accion=empleados">Administrar Empleados</a> |
    <a href="gerente.php?accion=autos">Administrar Autos</a> |
    <a href="index.php?logout=1">Cerrar Sesión</a>

    <hr>

    <?php
    switch ($accion) {
        case 'listar_alquileres':
            echo "<h2>Listado de Alquileres</h2>";
            $stmt = $pdo->query("SELECT a.id_alquiler, a.dpi_cliente, a.dpi_empleado, a.placa_auto, 
                                        a.hora_salida, a.hora_llegada, a.total_cobrado,
                                        c.nombres AS cliente_n, c.apellidos AS cliente_a,
                                        e.nombres AS empleado_n, e.apellidos AS empleado_a
                                 FROM alquileres a
                                 JOIN clientes c ON a.dpi_cliente = c.dpi
                                 JOIN empleados e ON a.dpi_empleado = e.dpi
                                 ORDER BY a.id_alquiler DESC");
            echo "<table border='1'>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Empleado</th>
                        <th>Auto</th>
                        <th>Salida</th>
                        <th>Llegada</th>
                        <th>Total Cobrado</th>
                    </tr>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>{$row['id_alquiler']}</td>
                        <td>{$row['cliente_n']} {$row['cliente_a']}</td>
                        <td>{$row['empleado_n']} {$row['empleado_a']}</td>
                        <td>{$row['placa_auto']}</td>
                        <td>{$row['hora_salida']}</td>
                        <td>" . ($row['hora_llegada'] ?? 'En curso') . "</td>
                        <td>" . ($row['total_cobrado'] ?? 'Pendiente') . "</td>
                      </tr>";
            }
            echo "</table>";
        break;

        case 'reporte':
            $ganancias = $pdo->query("SELECT SUM(total_cobrado) FROM alquileres")->fetchColumn() ?? 0;
            $gastos    = $pdo->query("SELECT SUM(sueldo_mensual) FROM empleados")->fetchColumn() ?? 0;
            echo "<h2>Reporte Financiero</h2>";
            echo "<p>Total Ganancias: Q$ganancias</p>";
            echo "<p>Total Sueldos (Gastos): Q$gastos</p>";
            echo "<p>Balance Neto: Q" . ($ganancias - $gastos) . "</p>";
            break;

        case 'autos':
            echo "<h2>Administrar Autos</h2>";
            echo "<a href='agregar_auto.php'>Agregar Auto</a><br><br>";
            $stmt = $pdo->query("SELECT * FROM autos");
            echo "<table border='1'>
                    <tr><th>Placa</th><th>Marca</th><th>Modelo</th><th>Disponible</th><th>Foto</th><th>Acciones</th></tr>";
            while ($auto = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>{$auto['placa']}</td>
                        <td>{$auto['marca']}</td>
                        <td>{$auto['modelo']}</td>
                        <td>" . ($auto['disponible'] ? 'Sí' : 'No') . "</td>
                        <td>";
                if ($auto['foto']) {
                    echo "<img src='{$auto['foto']}' width='100'>";
                } else {
                    echo "Sin foto";
                }
                echo "</td>
                        <td>
                            <a href='editar_auto.php?placa={$auto['placa']}'>Editar</a> |
                            <a href='eliminar_auto.php?placa={$auto['placa']}' onclick=\"return confirm('¿Eliminar este auto?')\">Eliminar</a>
                        </td>
                      </tr>";
            }
            echo "</table>";
        break;

        case 'empleados':
            echo "<h2>Administrar Empleados</h2>";
            echo "<a href='agregar_empleado.php'>Agregar Empleado</a><br><br>";
            $stmt = $pdo->query("SELECT * FROM empleados");
            echo "<table border='1'>
                    <tr>
                        <th>DPI</th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Sueldo</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>";
            while ($emp = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>{$emp['dpi']}</td>
                        <td>{$emp['nombres']} {$emp['apellidos']}</td>
                        <td>{$emp['telefono']}</td>
                        <td>{$emp['correo']}</td>
                        <td>{$emp['sueldo_mensual']}</td>
                        <td>{$emp['rol']}</td>
                        <td>
                            <a href='editar_empleado.php?dpi={$emp['dpi']}'>Editar</a> |
                            <a href='eliminar_empleado.php?dpi={$emp['dpi']}' onclick=\"return confirm('¿Eliminar este empleado?')\">Eliminar</a>
                        </td>
                      </tr>";
            }
            echo "</table>";
            break;

        default:
            echo "<h2>Bienvenido al Panel del Gerente</h2>";
            echo "<p>Selecciona una acción del menú superior.</p>";
            break;
    }
    ?>
    </div>
</body>
</html>
