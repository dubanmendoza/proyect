<?php
session_start();
if (!isset($_SESSION['nombre']) || $_SESSION['id_rol'] != 2) { // Solo permite acceso al administrador
    header('Location: login.php');
    exit();
}

include "Models/conexion.php";

// Obtener lista de usuarios con sus estados
$sql = "SELECT id_usuario, nombre, correo_electronico, estado, ultima_actividad FROM usuario";
$resultado = $conexion->query($sql);

// Mostrar todos los usuarios como activos hasta que cumplan los días de inactividad
$sql_inactivos = "UPDATE usuario SET estado = 'inactivo' WHERE DATEDIFF(NOW(), ultima_actividad) > 90 AND estado = 'activo'";
$conexion->query($sql_inactivos);

$sql_bloqueados = "UPDATE usuario SET estado = 'bloqueado' WHERE DATEDIFF(NOW(), ultima_actividad) > 120 AND estado = 'inactivo'";
$conexion->query($sql_bloqueados);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/interadmin.css">
</head>
<body>
    <div class="dashboard">
        <nav class="sidebar">
            <h2>FinzApp Admin</h2>
            <p>Administrador: <?php echo $_SESSION['nombre']; ?></p>
            <ul>
                <li><a href="cerrar_sesion.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
        <div class="content">
            <h2>Gestión de Usuarios</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo Electrónico</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($resultado && $resultado->num_rows > 0) {
                        while ($row = $resultado->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$row['id_usuario']}</td>";
                            echo "<td>{$row['nombre']}</td>";
                            echo "<td>{$row['correo_electronico']}</td>";
                            echo "<td>{$row['estado']}</td>";
                            echo "<td>";
                            
                            // Calcular los días de inactividad
                            $dias_inactividad = (strtotime("now") - strtotime($row['ultima_actividad'])) / 86400; // 86400 segundos en un día
                            
                            // Colocar las acciones de forma lateral (en una fila horizontal)
                            echo "<div class='acciones-laterales'>";
                            
                            // Mostrar opciones según el estado del usuario y los días de inactividad
                            if ($row['estado'] == 'activo') {
                                if ($dias_inactividad > 90) {
                                    // Si el usuario está activo y ha pasado más de 90 días, ofrecer desactivar
                                    echo "<form method='POST' action='interfazadmin.php'>
                                              <input type='hidden' name='id_usuario' value='{$row['id_usuario']}'>
                                              <input type='hidden' name='accion' value='desactivar'>
                                              <button type='submit' class='desactivar'>Desactivar</button>
                                          </form>";
                                }
                            } elseif ($row['estado'] == 'inactivo' && $dias_inactividad > 120) {
                                // Si el usuario está inactivo y ha pasado más de 120 días, ofrecer desbloquear
                                echo "<form method='POST' action='interfazadmin.php'>
                                          <input type='hidden' name='id_usuario' value='{$row['id_usuario']}'>
                                          <input type='hidden' name='accion' value='activar'>
                                          <button type='submit' class='activar'>Desbloquear</button>
                                      </form>";
                            } elseif ($row['estado'] == 'bloqueado') {
                                echo "Bloqueado";
                            }
                            
                            echo "</div>"; // Cerrar div de acciones laterales
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No hay usuarios registrados</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
