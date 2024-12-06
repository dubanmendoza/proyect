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

// Procesar el formulario de pagos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_pago = $_POST['nombre_pago'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_final = $_POST['fecha_final'];
    $valor = $_POST['valor'];
    $id_ingreso = $_POST['id_ingreso'];  // Agregar el id_ingreso aquí

    // Insertar el pago en la base de datos
    $sql = "INSERT INTO pagos (nombre_pago, fecha_inicio, fecha_final, valor, id_ingreso_fk) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);

    // Asegurarse de que los parámetros coincidan con la consulta SQL
    $stmt->bind_param("ssssd", $nombre_pago, $fecha_inicio, $fecha_final, $valor, $id_ingreso);  // Agregar 'd' para id_ingreso
    $stmt->execute();

    // Verificar si la inserción fue exitosa
    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Pago registrado exitosamente');</script>";
    } else {
        echo "<script>alert('Error al registrar el pago');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Pagos</h2>

        <!-- Formulario para registrar pagos -->
        <form method="POST" action="pagos.php">
            <table class="table table-white">
                <thead>
                    <tr>
                        <th>Nombre del pago</th>
                        <th>Fecha de inicio</th>
                        <th>Fecha final</th>
                        <th>Valor</th>
                        <th>Ingreso relacionado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" id="nombre_pago" name="nombre_pago" class="form-control" required></td>
                        <td><input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" required></td>
                        <td><input type="date" id="fecha_final" name="fecha_final" class="form-control" required></td>
                        <td><input type="number" id="valor" name="valor" class="form-control" step="0.01" required></td>
                        <td>
                            <select id="id_ingreso" name="id_ingreso" class="form-control" required>
                                <?php
                                // Consultar los ingresos del usuario
                                $sql = "SELECT id_ingreso, nombre_ingreso FROM ingresos WHERE id_usuario_fk = ?";
                                $stmt = $conexion->prepare($sql);
                                $stmt->bind_param("i", $_SESSION['id_usuario']);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['id_ingreso'] . "'>" . $row['nombre_ingreso'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </td>
                        <td><button type="submit" class="btn btn-success">Añadir</button></td>
                    </tr>
                </tbody>
            </table>
        </form>

        <!-- Tabla para mostrar pagos registrados -->
        <h3 class="mt-4">Lista de Pagos</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre del pago</th>
                    <th>Fecha de inicio</th>
                    <th>Fecha final</th>
                    <th>Valor</th>
                    <th>Ingreso relacionado</th>
                    <th>Monto del ingreso</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Consultar los pagos e ingresos directamente
                $sql = "SELECT p.nombre_pago, p.fecha_inicio, p.fecha_final, p.valor, i.nombre_ingreso, i.monto_ingreso
                        FROM pagos p
                        JOIN ingresos i ON p.id_ingreso_fk = i.id_ingreso
                        WHERE i.id_usuario_fk = ?";
                $stmt = $conexion->prepare($sql);
                $stmt->bind_param("i", $_SESSION['id_usuario']);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['nombre_pago'] . "</td>";
                        echo "<td>" . $row['fecha_inicio'] . "</td>";
                        echo "<td>" . $row['fecha_final'] . "</td>";
                        echo "<td>" . $row['valor'] . "</td>";
                        echo "<td>" . $row['nombre_ingreso'] . "</td>";
                        echo "<td>" . $row['monto_ingreso'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo '<tr><td colspan="6" class="text-center">No se han registrado pagos</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
