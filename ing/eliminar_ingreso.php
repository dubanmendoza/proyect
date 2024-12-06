<?php
include "../models/conexion.php";

$id = $_GET['id'];
$sql = "DELETE FROM ingresos WHERE id_ingreso = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: ../ingresos.php");
} else {
    echo "Error al eliminar el ingreso.";
}
?>