<?php
session_start();
require "conexion.php";

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'gerente') {
    header("Location: index.php");
    exit;
}

if (!isset($_GET['dpi'])) {
    header("Location: gerente.php");
    exit;
}

$dpi = $_GET['dpi'];

$stmt = $pdo->prepare("SELECT * FROM empleados WHERE dpi = ?");
$stmt->execute([$dpi]);
$empleado = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$empleado) {
    echo "Empleado no encontrado.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar empleado</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h2>Editar Empleado</h2>
    <form action="actualizar_empleado.php" method="POST">
        <input type="hidden" name="dpi" value="<?php echo $empleado['dpi']; ?>">

        <label>Rol:</label>
        <select name="rol" required>
            <option value="gerente" <?php if($empleado['rol']=="gerente") echo "selected"; ?>>Gerente</option>
            <option value="limpieza" <?php if($empleado['rol']=="limpieza") echo "selected"; ?>>Limpieza</option>
            <option value="atencion" <?php if($empleado['rol']=="atencion") echo "selected"; ?>>Atención</option>
        </select><br>

        <label>Nombres:</label>
        <input type="text" name="nombres" value="<?php echo $empleado['nombres']; ?>" required><br>

        <label>Apellidos:</label>
        <input type="text" name="apellidos" value="<?php echo $empleado['apellidos']; ?>" required><br>

        <label>Teléfono:</label>
        <input type="text" name="telefono" value="<?php echo $empleado['telefono']; ?>" required><br>

        <label>Correo:</label>
        <input type="email" name="correo" value="<?php echo $empleado['correo']; ?>" required><br>

        <label>Sueldo mensual:</label>
        <input type="number" step="0.01" name="sueldo_mensual" value="<?php echo $empleado['sueldo_mensual']; ?>" required><br>

        <label>Usuario:</label>
        <input type="text" name="username" value="<?php echo $empleado['username']; ?>" required><br>

        <label>Contraseña (dejar en blanco para no cambiar):</label>
        <input type="password" name="passwrd"><br>

        <button type="submit">Actualizar</button>
    </form>
    <br>
    <a href="gerente.php">Volver</a>
</body>
</html>