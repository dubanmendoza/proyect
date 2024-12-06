<?php
include "../models/conexion.php";

$id = $_GET['id'];
$sql = "DELETE FROM gastos WHERE id_gasto = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: ../gastos.php");
} else {
    echo "Error al eliminar el gasto.";
}
?>