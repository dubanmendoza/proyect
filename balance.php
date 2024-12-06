<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Asegúrate de iniciar la sesión solo si no hay una activa
}

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    echo '<div class="alert alert-danger" role="alert">Error: No has iniciado sesión.</div>';
    exit;
}

$id_usuario = $_SESSION['id_usuario']; // Obtener el ID del usuario en sesión

// Conexión a la base de datos
include "models/conexion.php";

// Consulta para obtener el total de ingresos del usuario
$ingresos_sql = "SELECT SUM(monto_ingreso) AS total_ingresos FROM ingresos WHERE id_usuario_fk = ?";
$stmt_ingresos = $conexion->prepare($ingresos_sql);
$stmt_ingresos->bind_param("i", $id_usuario);
$stmt_ingresos->execute();
$result_ingresos = $stmt_ingresos->get_result();
$total_ingresos = ($result_ingresos->num_rows > 0) ? $result_ingresos->fetch_assoc()['total_ingresos'] : 0;

// Consulta para obtener el total de gastos del usuario
$gastos_sql = "SELECT SUM(monto_gasto) AS total_gastos FROM gastos WHERE id_usuario_fk = ?";
$stmt_gastos = $conexion->prepare($gastos_sql);
$stmt_gastos->bind_param("i", $id_usuario);
$stmt_gastos->execute();
$result_gastos = $stmt_gastos->get_result();
$total_gastos = ($result_gastos->num_rows > 0) ? $result_gastos->fetch_assoc()['total_gastos'] : 0;

// Calcular el balance
$balance = $total_ingresos - $total_gastos;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-3">Balance</h2>
        <p class="text-muted">Resumen de tus ingresos y gastos.</p>

        <!-- Tabla de Resumen -->
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Concepto</th>
                    <th>Monto</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total de Ingresos</td>
                    <td class="text-success">+$<?php echo number_format($total_ingresos, 2); ?></td>
                </tr>
                <tr>
                    <td>Total de Gastos</td>
                    <td class="text-danger">-$<?php echo number_format($total_gastos, 2); ?></td>
                </tr>
                <tr>
                    <th>Balance</th>
                    <th class="<?php echo $balance >= 0 ? 'text-success' : 'text-danger'; ?>">
                        $<?php echo number_format($balance, 2); ?>
                    </th>
                </tr>
            </tbody>
        </table>

        <!-- Mensaje basado en el balance -->
        <div class="alert <?php echo $balance >= 0 ? 'alert-success' : 'alert-danger'; ?>" role="alert">
            <?php
            if ($balance >= 0) {
                echo "¡Bien hecho! Tu balance es positivo.";
            } else {
                echo "Atención: Tu balance es negativo. Considera ajustar tus gastos.";
            }
            ?>
        </div>
    </div>
</body>
</html>