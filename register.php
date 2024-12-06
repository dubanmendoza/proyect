<?php
include 'models/conexion.php'; // Conexión a la base de datos

$message = ''; // Variable para almacenar el mensaje de resultado


if (!empty($_POST['registrar'])) {
    if (!empty($_POST['nom']) && !empty($_POST['dir']) && !empty($_POST['cor']) && !empty($_POST['con'])) {

        $nombre = $_POST["nom"];
        $cor = $_POST["cor"];
        $con = $_POST["con"];

        if ($conexion) {
            $sql = "INSERT INTO usuario (nombre, correo_electronico, contrasena) VALUES ('$nombre', '$cor', '$con')";
            $result_sql = $conexion->query($sql);
            echo '<div class="alert alert-success">Registro Satisfactorio</div>';
        } else {
            echo '<div class="alert alert-danger">Error de conexion</div>';
        }

    } else {
        echo '<div class="alert alert-warning">Datos Incompletos</div>';
    }
}

?>

