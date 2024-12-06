<?php

if (!empty($_POST['registrar'])) {
    if (!empty($_POST['nom']) && !empty($_POST['cor']) && !empty($_POST['con'])) {

        $nombre = $_POST["nom"];
        $cor = $_POST["cor"];
        $con = $_POST["con"];

        // Asegúrate de usar una conexión activa
        include_once 'models/conexion.php';

        if ($conexion) {
            // Encriptar la contraseña antes de guardarla
            $hashed_password = password_hash($con, PASSWORD_BCRYPT);

            // Asignar el rol de usuario (1)
            $rol = 1;

            // Insertar en la base de datos
            $sql = "INSERT INTO usuario (nombre, correo_electronico, contrasena, id_rol) VALUES ('$nombre', '$cor', '$con', '$rol')";
            $result_sql = $conexion->query($sql);

            if ($result_sql) {
                echo '<div class="alert alert-success">Registro Satisfactorio</div>';
            } else {
                echo '<div class="alert alert-danger">Error al registrar el usuario</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Error de conexión</div>';
        }

    } else {
        echo '<div class="alert alert-warning">Datos Incompletos</div>';
    }
}
?>