<?php

$servername = "localhost:3307";
$username = "root";
$password = "Dubanpro124"; 
$dbname = "proyecto";

// Crear conexión
$conexion = new mysqli($servername, $username, $password, $dbname);

// Comprobar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Verificar si hay errores de conexión
if (mysqli_connect_errno()) {
    echo "Código de error: " . mysqli_connect_errno();
    exit();
}

// echo "Conectado exitosamente"; 
?>