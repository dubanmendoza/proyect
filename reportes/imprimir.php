<?php
// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario'])) {
    die("Usuario no autenticado.");
}

// Verificar tipo de reporte válido
if (!isset($_GET['tipo']) || !in_array($_GET['tipo'], ['gastos', 'ingresos', 'metas'])) {
    die("Tipo de reporte no válido.");
}

$tipo = $_GET['tipo'];

// Ajustar la ruta al archivo de conexión
include "../Models/conexion.php"; // Cambia la ruta si es necesario

$id_usuario = $_SESSION['id_usuario'];

// Definir la consulta según el tipo de reporte
switch ($tipo) {
    case 'gastos':
        $sql = "SELECT nombre_gasto AS nombre, monto_gasto AS monto, fecha_gasto AS fecha FROM gastos WHERE id_usuario_fk = ?";
        break;
    case 'ingresos':
        $sql = "SELECT nombre_ingreso AS nombre, monto_ingreso AS monto, fecha_ingreso AS fecha FROM ingresos WHERE id_usuario_fk = ?";
        break;
    case 'metas':
        // Consulta actualizada para metas
        $sql = "SELECT nombre_meta AS nombre, monto_meta AS monto, fecha_inicio, fecha_final FROM metas WHERE id_usuario_fk = ?";
        break;
    default:
        die("Tipo de reporte no válido.");
}

// Preparar y ejecutar la consulta
$stmt = $conexion->prepare($sql);
if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conexion->error);
}

$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {
    die("No se encontraron datos para este usuario y tipo de reporte.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print, .no-print * {
                display: none; /* Oculta elementos con la clase no-print al imprimir */
            }
        }
    </style>
    <title>Reporte de <?php echo ucfirst($tipo); ?></title>
</head>
<body>
<div class="container">
    <h2>Lista de <?php echo ucfirst($tipo); ?></h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Monto</th>
                <?php if ($tipo !== 'metas'): ?>
                    <th>Fecha</th>
                <?php else: ?>
                    <th>Fecha de Inicio</th>
                    <th>Fecha Final</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php while ($fila = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($fila['nombre']); ?></td>
                    <td><?php echo number_format($fila['monto'], 2); ?></td>
                    <?php if ($tipo !== 'metas'): ?>
                        <td><?php echo htmlspecialchars($fila['fecha']); ?></td>
                    <?php else: ?>
                        <td><?php echo htmlspecialchars($fila['fecha_inicio']); ?></td>
                        <td><?php echo htmlspecialchars($fila['fecha_final']); ?></td>
                    <?php endif; ?>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div class="no-print">
        <a href="../<?php echo $tipo; ?>.php" class="btn btn-dark">Regresar</a>
        <a href="generarExcel.php?tipo=<?php echo $tipo; ?>" class="btn btn-success">Generar Excel</a>
        <a href="" class="btn btn-warning" onclick="window.print()">Imprimir</a>
    </div>
</div>
</body>
</html>