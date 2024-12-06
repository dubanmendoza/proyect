<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "Models/conexion.php";

// Verificar si el usuario está logueado
if (!isset($_SESSION['nombre']) || $_SESSION['id_rol'] != 1) {
    header('Location: login.php');
    exit();
}

// Variable para almacenar el mensaje de resultado
$message = '';

// Procesar el formulario de gastos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_gasto = $_POST['nombre_gasto'];
    $monto_gasto = $_POST['monto_gasto'];
    $fecha_gasto = $_POST['fecha_gasto'];
    $id_usuario = $_SESSION['id_usuario'];

    // Insertar el gasto en la base de datos
    $sql = "INSERT INTO gastos (id_usuario_fk, nombre_gasto, monto_gasto, fecha_gasto) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("isds", $id_usuario, $nombre_gasto, $monto_gasto, $fecha_gasto);
    
    if ($stmt->execute()) {
        $message = '<div class="alert alert-success">Gasto registrado exitosamente.</div>';
    } else {
        $message = '<div class="alert alert-danger">Error al registrar el gasto.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gastos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Gastos</h2>

        <!-- Mostrar mensaje de resultado -->
        <?php if ($message) echo $message; ?>

        <!-- Formulario para registrar gastos -->
        <form method="POST" action="gastos.php">
            <table class="table table-white">
                <thead>
                    <tr>
                        <th>Nombre del gasto</th>
                        <th>Monto</th>
                        <th>Fecha del gasto</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" id="nombre_gasto" name="nombre_gasto" class="form-control" required></td>
                        <td><input type="number" id="monto_gasto" name="monto_gasto" class="form-control" step="0.01" required></td>
                        <td><input type="date" id="fecha_gasto" name="fecha_gasto" class="form-control" required></td>
                        <td><button type="submit" class="btn btn-success">Añadir</button></td>
                    </tr>
                </tbody>
            </table>
        </form>

        <!-- Tabla para mostrar gastos registrados -->
        <h3 class="mt-4">Lista de Gastos</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre del gasto</th>
                    <th>Monto</th>
                    <th>Fecha del gasto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Consultar los gastos del usuario
                $sql = "SELECT g.id_gasto, g.nombre_gasto, g.monto_gasto, g.fecha_gasto
                        FROM gastos g
                        WHERE g.id_usuario_fk = ?";
                $stmt = $conexion->prepare($sql);
                $stmt->bind_param("i", $_SESSION['id_usuario']);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['nombre_gasto'] . "</td>";
                        echo "<td>" . $row['monto_gasto'] . "</td>";
                        echo "<td>" . $row['fecha_gasto'] . "</td>";
                        echo "<td>";
                        echo "<a href='gas/modificar_gasto.php?id=" . $row['id_gasto'] . "' class='btn btn-warning btn-sm'>Modificar</a> ";
                        echo "<a href='gas/eliminar_gasto.php?id=" . $row['id_gasto'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Estás seguro de eliminar este gasto?\");'>Eliminar</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo '<tr><td colspan="4" class="text-center">No se han registrado gastos</td></tr>';
                }
                ?>
                <a href="reportes/imprimir.php?tipo=gastos" class="btn btn-primary">Detalles</a>

            </tbody>
        </table>
    </div>
</body>
</html>