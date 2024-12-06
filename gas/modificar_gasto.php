<?php
include "../models/conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM gastos WHERE id_gasto = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            ?>
            <form method="POST" action="modificar_gasto.php?id=<?php echo $row['id_gasto']; ?>">
                <input type="hidden" name="id_gasto" value="<?php echo $row['id_gasto']; ?>">
                <label>Nombre:</label>
                <input type="text" name="nombre_gasto" value="<?php echo $row['nombre_gasto']; ?>" required>
                <label>Monto:</label>
                <input type="number" name="monto_gasto" value="<?php echo $row['monto_gasto']; ?>" step="0.01" required>
                <label>Fecha:</label>
                <input type="date" name="fecha_gasto" value="<?php echo $row['fecha_gasto']; ?>" required>
                <button type="submit">Guardar cambios</button>
            </form>
            <?php
        } else {
            echo "gasto no encontrado.";
        }
    } else {
        echo "ID inválido.";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_gasto'];
    $nombre = $_POST['nombre_gasto'];
    $monto = $_POST['monto_gasto'];
    $fecha = $_POST['fecha_gasto'];

    $sql = "UPDATE gastos SET nombre_gasto = ?, monto_gasto = ?, fecha_gasto = ? WHERE id_gasto = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sdsi", $nombre, $monto, $fecha, $id);

    if ($stmt->execute()) {
        header("Location: ../gastos.php");
        exit();
    } else {
        echo "Error al actualizar el gasto: " . $stmt->error;
    }
}
?>
