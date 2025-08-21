<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
</head>
<body>
  <h2>Iniciar Sesión</h2>
  <form action="procesar_login.php" method="POST">
    <label>Usuario:</label>
    <input type="text" name="username" required><br><br>

    <label>Contraseña:</label>
    <input type="password" name="passwrd" required><br><br>

    <button type="submit">Ingresar</button>
  </form>
</body>
</html>