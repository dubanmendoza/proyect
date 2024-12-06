<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "Models/conexion.php";

// Verificar si el usuario está logueado
if (!isset($_SESSION['nombre']) || $_SESSION['id_rol'] != 1 || !isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}

// Variable para almacenar el mensaje de resultado
$message = '';

// Procesar el formulario de ingresos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si las claves existen en $_POST
    if (isset($_POST['nombre_ingreso'], $_POST['monto_ingreso'], $_POST['fecha_ingreso'])) {
        $nombre_ingreso = $_POST['nombre_ingreso'];
        $monto_ingreso = $_POST['monto_ingreso'];
        $fecha_ingreso = $_POST['fecha_ingreso'];
        $id_usuario = $_SESSION['id_usuario'];

        // Insertar el ingreso en la base de datos
        $sql = "INSERT INTO ingresos (id_usuario_fk, nombre_ingreso, monto_ingreso, fecha_ingreso) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("isds", $id_usuario, $nombre_ingreso, $monto_ingreso, $fecha_ingreso);
        
        if ($stmt->execute()) {
            $message = '<div class="alert alert-success">Ingreso registrado exitosamente.</div>';
        } else {
            $message = '<div class="alert alert-danger">Error al registrar el ingreso: ' . $stmt->error . '</div>';
        }
    } else {
        $message = '<div class="alert alert-danger">Por favor, completa todos los campos.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Ingresos</h2>

        <!-- Mostrar mensaje de resultado -->
        <?php if ($message) echo $message; ?>

        <!-- Formulario para registrar ingresos -->
        <form method="POST" action="ingresos.php">
            <table class="table table-white">
                <thead>
                    <tr>
                        <th>Nombre del ingreso</th>
                        <th>Monto</th>
                        <th>Fecha del ingreso</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" id="nombre_ingreso" name="nombre_ingreso" class="form-control" required></td>
                        <td><input type="number" id="monto_ingreso" name="monto_ingreso" class="form-control" step="0.01" required></td>
                        <td><input type="date" id="fecha_ingreso" name="fecha_ingreso" class="form-control" required></td>
                        <td><button type="submit" class="btn btn-success">Añadir</button></td>
                    </tr>
                </tbody>
            </table>
        </form>

        <!-- Tabla para mostrar ingresos registrados -->
        <h3 class="mt-4">Lista de Ingresos</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre del ingreso</th>
                    <th>Monto</th>
                    <th>Fecha del ingreso</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody> 
                <?php
                // Consultar los ingresos del usuario
                $sql = "SELECT i.id_ingreso, i.nombre_ingreso, i.monto_ingreso, i.fecha_ingreso
                FROM ingresos i
                WHERE i.id_usuario_fk = ?";
        
                $stmt = $conexion->prepare($sql);
                $stmt->bind_param("i", $_SESSION['id_usuario']);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['nombre_ingreso']) . "</td>";
                        echo "<td>" . number_format($row['monto_ingreso'], 2) . "</td>";
                        echo "<td>" . htmlspecialchars($row['fecha_ingreso']) . "</td>";
                        echo "<td>";
                        echo "<a href='ing/modificar_ingresos.php?id=" . $row['id_ingreso'] . "' class='btn btn-warning btn-sm'>Modificar</a> ";
                        echo "<a href='ing/eliminar_ingreso.php?id=" . $row['id_ingreso'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Estás seguro de eliminar este ingreso?\");'>Eliminar</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo '<tr><td colspan="4" class="text-center">No se han registrado ingresos</td></tr>';
                }
                ?>
                

                    
                <a href="reportes/imprimir.php?tipo=ingresos" class="btn btn-primary">Detalles</a>
                    
                
            </tbody>
        </table>
    </div>
</body>
</html>