<?php
$host = "localhost";       // Servidor de base de datos
$usuario = "root";         // Usuario de la base de datos
$contrasena = "";          // Contraseña (vacía por defecto en localhost)
$basedatos = "ticketv2";   // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($host, $usuario, $contrasena);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Seleccionar la base de datos deseada
if (!mysqli_select_db($conn, $basedatos)) {
    die("Error al seleccionar la base de datos: " . mysqli_error($conn));
}

// Si todo está bien, puedes usar $conn para tus consultas
// echo "Conexión exitosa !!";
?>