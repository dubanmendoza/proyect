<?php
include "../models/conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM metas WHERE id_meta = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            ?>
            <form method="POST" action="modificar_meta.php?id=<?php echo $row['id_meta']; ?>">
                <input type="hidden" name="id_meta" value="<?php echo $row['id_meta']; ?>">
                <label>Nombre de la meta:</label>
                <input type="text" name="nombre_meta" value="<?php echo $row['nombre_meta']; ?>" required>
                <label>Monto:</label>
                <input type="number" name="monto_meta" value="<?php echo $row['monto_meta']; ?>" step="0.01" required>
                <label>Fecha de inicio:</label>
                <input type="date" name="fecha_inicio" value="<?php echo $row['fecha_inicio']; ?>" required>
                <label>Fecha final:</label>
                <input type="date" name="fecha_final" value="<?php echo $row['fecha_final']; ?>" required>
                <label>Porcentaje asignado:</label>
                <input type="number" name="porcentaje_asignado" value="<?php echo $row['porcentaje_asignado']; ?>" required>
                <button type="submit">Guardar cambios</button>
            </form>
            <?php
        } else {
            echo "Meta no encontrada.";
        }
    } else {
        echo "ID inválido.";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_meta'];
    $nombre = $_POST['nombre_meta'];
    $monto = $_POST['monto_meta'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_final = $_POST['fecha_final'];
    $porcentaje_asignado = $_POST['porcentaje_asignado'];

    $sql = "UPDATE metas SET nombre_meta = ?, monto_meta = ?, fecha_inicio = ?, fecha_final = ?, porcentaje_asignado = ? WHERE id_meta = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sdssdi", $nombre, $monto, $fecha_inicio, $fecha_final, $porcentaje_asignado, $id);

    if ($stmt->execute()) {
        header("Location: ../metas.php");
        exit();
    } else {
        echo "Error al actualizar la meta: " . $stmt->error;
    }
}
?>