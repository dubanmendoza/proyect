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

// Procesar el formulario de metas
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_meta = $_POST['nombre_meta'];
    $monto_meta = $_POST['monto_meta'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_final = $_POST['fecha_final'];
    $porcentaje_asignado = $_POST['porcentaje_asignado']; // Suponiendo que el usuario ingresa solo el número

    // Validar el porcentaje asignado
    if ($porcentaje_asignado < 0 || $porcentaje_asignado > 100) {
        die("Error: El porcentaje asignado debe estar entre 0 y 100.");
    }

    $id_usuario = $_SESSION['id_usuario'];

    // Insertar la meta en la base de datos
    $sql = "INSERT INTO metas (id_usuario_fk, nombre_meta, monto_meta, fecha_inicio, fecha_final, porcentaje_asignado) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("isdsss", $id_usuario, $nombre_meta, $monto_meta, $fecha_inicio, $fecha_final, $porcentaje_asignado);
    
    // Ejecutar la consulta y verificar errores
    if (!$stmt->execute()) {
        die("Error al insertar en la base de datos: " . $stmt->error);
    }
}

// Consultar las metas del usuario
$sql = "SELECT id_meta, nombre_meta, monto_meta, fecha_inicio, fecha_final, porcentaje_asignado
        FROM metas
        WHERE id_usuario_fk = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $_SESSION['id_usuario']);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Metas</h2>

        <!-- Formulario para registrar metas -->
        <form method="POST" action="metas.php">
            <table class="table table-white">
                <thead>
                    <tr>
                        <th>Nombre de la meta</th>
                        <th>Monto</th>
                        <th>Fecha de inicio</th>
                        <th>Fecha final</th>
                        <th>Porcentaje asignado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" id="nombre_meta" name="nombre_meta" class="form-control" required></td>
                        <td><input type="number" id="monto_meta" name="monto_meta" class="form-control" step="0.01" required></td>
                        <td><input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" required></td>
                        <td><input type="date" id="fecha_final" name="fecha_final" class="form-control" required></td>
                        <td>
                            <input type="number" id="porcentaje_asignado" name="porcentaje_asignado" class="form-control" step="0.01" required>
                            <small class="form-text text-muted">Ingresa solo el número (ej. 10 para 10%).</small>
                        </td>
                        <td><button type="submit" class="btn btn-success">Añadir</button></td>
                    </tr>
                </tbody>
            </table>
        </form>

        <!-- Tabla para mostrar metas registradas -->
        <h3 class="mt-4">Lista de Metas</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre de la meta</th>
                    <th>Monto</th>
                    <th>Fecha de inicio</th>
                    <th>Fecha final</th>
                    <th>Porcentaje asignado</th>
                    <th>Ahorro mensual</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $fecha_inicio = new DateTime($row['fecha_inicio']);
                        $fecha_final = new DateTime($row['fecha_final']);
                        $diferencia = $fecha_final->diff($fecha_inicio);
                        $meses = $diferencia->m + ($diferencia->y * 12); // Obtener la diferencia en meses

                        // Calcular el ahorro mensual correctamente
                        $total_aahorrar = $row['monto_meta'] * ($row['porcentaje_asignado'] / 100); // Monto total a ahorrar según el porcentaje
                        $ahorro_mensual = $meses > 0 ? $total_aahorrar / $meses : 0; // Calcular el ahorro mensual

                        echo "<tr>
                                <td>{$row['nombre_meta']}</td>
                                <td>{$row['monto_meta']}</td>
                                <td>{$row['fecha_inicio']}</td>
                                <td>{$row['fecha_final']}</td>
                                <td>{$row['porcentaje_asignado']}%</td>
                                <td>" . number_format($ahorro_mensual, 2) . "</td>
                                <td>
                                    <a href='metas/modificar_meta.php?id=" . $row['id_meta'] . "' class='btn btn-warning btn-sm'>Modificar</a>
                                    <a href='metas/eliminar_meta.php?id=" . $row['id_meta'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Estás seguro de eliminar esta meta?\");'>Eliminar</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No hay metas registradas.</td></tr>";
                }
                ?>
                <a href="reportes/imprimir.php?tipo=metas" class="btn btn-primary">Detalles</a>

            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
