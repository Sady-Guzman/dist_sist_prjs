<?php
session_start();
include "backend/conexion.php";

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];

    $sql="SELECT * FROM usuarios WHERE usuario = '$usuario' AND clave = '$clave'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $_SESSION['usuario'] = $usuario;
		$_SESSION['clave'] = $clave;
        header("Location: frontend/reservas.php");
        exit();
    } else {
        $mensaje = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Reservas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">

<div class="card p-4 shadow-lg" style="min-width: 300px; max-width: 400px; width: 100%;">
    <h4 class="text-center mb-4">Book Your Concert!</h4>

    <?php if ($mensaje): ?>
        <div class="alert alert-danger" role="alert">
            <?= $mensaje ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label for="usuario" class="form-label">Usuario</label>
            <input type="text" class="form-control" id="usuario" name="usuario" required>
        </div>
        <div class="mb-3">
            <label for="clave" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="clave" name="clave" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Entrar</button>
    </form>
</div>

</body>
</html>
