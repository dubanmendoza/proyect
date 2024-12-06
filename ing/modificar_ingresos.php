<?php
include "../models/conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM ingresos WHERE id_ingreso = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            ?>
            <form method="POST" action="modificar_ingresos.php?id=<?php echo $row['id_ingreso']; ?>">
                <input type="hidden" name="id_ingreso" value="<?php echo $row['id_ingreso']; ?>">
                <label>Nombre:</label>
                <input type="text" name="nombre_ingreso" value="<?php echo $row['nombre_ingreso']; ?>" required>
                <label>Monto:</label>
                <input type="number" name="monto_ingreso" value="<?php echo $row['monto_ingreso']; ?>" step="0.01" required>
                <label>Fecha:</label>
                <input type="date" name="fecha_ingreso" value="<?php echo $row['fecha_ingreso']; ?>" required>
                <button type="submit">Guardar cambios</button>
            </form>
            <?php
        } else {
            echo "Ingreso no encontrado.";
        }
    } else {
        echo "ID inválido.";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_ingreso'];
    $nombre = $_POST['nombre_ingreso'];
    $monto = $_POST['monto_ingreso'];
    $fecha = $_POST['fecha_ingreso'];

    $sql = "UPDATE ingresos SET nombre_ingreso = ?, monto_ingreso = ?, fecha_ingreso = ? WHERE id_ingreso = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sdsi", $nombre, $monto, $fecha, $id);

    if ($stmt->execute()) {
        header("Location: ../ingresos.php");
        exit();
    } else {
        echo "Error al actualizar el ingreso: " . $stmt->error;
    }
}
?>
