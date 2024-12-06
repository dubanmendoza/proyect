<?php
include "../models/conexion.php";

$id = $_GET['id'];
$sql = "DELETE FROM metas WHERE id_meta = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: ../metas.php");
} else {
    echo "Error al eliminar la meta.";
}
?>