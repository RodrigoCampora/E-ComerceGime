<?php
session_start();
include "db.ph";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form method="post">
        <label>Usuario:</label>
        <input type="text" name="username" required>
        <label>Contraseña:</label>
        <input type="text" name="password" required>
        <button type="submit">Ingresar</button>
    </form>
    <p>¿No tenés cuenta? <a href="registro.php">Registrate aquí</a></p>
</body>
</html>