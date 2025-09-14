<?php
session_start();
include "db.ph";
if($_SERVER["REQUEST_METHOD"=="POST"]){
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, is_admin, cart FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($id, $hash, $is_admin, $cart);

    if ($stmt->fetch() && password_verify($pass, $hash)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['email'] = $email;
        $_SESSION['is_admin'] = $is_admin;
        $_SESSION['cart'] = json_decode($cart, true);
        header("Location: index.php");
        exit;
    } else {
        echo "Credenciales incorrectas.";
    }
}
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
    <p>¿No tenés cuenta? <a href="register.php">Registrate aquí</a></p>
</body>
</html>