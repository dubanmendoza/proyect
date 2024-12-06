<?php

include_once "../models/conexion.php";

if (!empty($_GET['id_usuario'])) {
    $id = $_GET['id_usuario'];

    // Preparar la consulta para eliminar un usuario
    $sql = "DELETE FROM usuario WHERE id_usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('i', $id);

    try {
        if ($stmt->execute()) {
            echo '<div class="alert alert-success">Usuario Eliminado Satisfactoriamente</div>';
        } else {
            throw new Exception($conexion->error, $conexion->errno);
        }
    } catch (Exception $e) {
        // Capturar el error de restricción de llave externa
        if ($e->getCode() == 1451) {
            echo '<div class="alert alert-warning">No se puede eliminar el usuario porque tiene dependencias.</div>';
        } else {
            echo '<div class="alert alert-danger">Error al eliminar el usuario: ' . $e->getMessage() . '</div>';
        }
    }

    $stmt->close();
}
?>