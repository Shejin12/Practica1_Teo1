<head>
    <link rel="stylesheet" href="estilos.css">
</head>

<form action="guardar_empleado.php" method="POST">
    <input type="text" name="dpi" placeholder="DPI" required><br>
    <input type="text" name="nombres" placeholder="Nombres" required><br>
    <input type="text" name="apellidos" placeholder="Apellidos" required><br>
    <input type="text" name="telefono" placeholder="Teléfono" required><br>
    <input type="email" name="correo" placeholder="Correo"><br>
    <input type="number" step="0.01" name="sueldo" placeholder="Sueldo" required><br>
    <input type="text" name="username" placeholder="Usuario" required><br>
    <input type="password" name="passwrd" placeholder="Contraseña" required><br>
    <select name="rol">
        <option value="gerente">Gerente</option>
        <option value="limpieza">Limpieza</option>
        <option value="atencion">Atención</option>
    </select><br>
    <button type="submit">Guardar</button>
</form>