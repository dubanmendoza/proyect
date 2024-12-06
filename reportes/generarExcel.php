
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
        $sql = "SELECT nombre_meta AS nombre, monto_meta AS monto, fecha_meta AS fecha FROM metas WHERE id_usuario_fk = ?";
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

// Configurar encabezados para exportación a Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reporte_" . $tipo . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

// Imprimir datos en formato de tabla para Excel
echo "<table border='1'>";
echo "<tr><th>Nombre</th><th>Monto</th><th>Fecha</th></tr>";

while ($fila = $resultado->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($fila['nombre']) . "</td>";
    echo "<td>" . number_format($fila['monto'], 2) . "</td>";
    echo "<td>" . htmlspecialchars($fila['fecha']) . "</td>";
    echo "</tr>";
}

echo "</table>";
?>
