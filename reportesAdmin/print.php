<?php
session_start();
if (!isset($_SESSION['nombre']) || $_SESSION['id_rol'] != 2) { // Solo permite acceso al administrador
    header('Location: login.php');
    exit();
}

include "../Models/conexion.php";

// Actualizar estados automáticamente según la inactividad
$sql_inactivos = "UPDATE usuario SET estado = 'inactivo' 
                 WHERE DATEDIFF(NOW(), ultima_actividad) > 90 AND estado = 'activo'";
$conexion->query($sql_inactivos);

$sql_eliminar = "DELETE FROM usuario 
                WHERE DATEDIFF(NOW(), ultima_actividad) > 120 AND estado = 'inactivo'";
$conexion->query($sql_eliminar);

// Verificar si se ha enviado una acción para activar un usuario
if (isset($_POST['accion']) && isset($_POST['id_usuario'])) {
    $id_usuario = $_POST['id_usuario'];
    $accion = $_POST['accion'];

    if ($accion == 'activar') {
        // Activar al usuario (de 'inactivo' a 'activo')
        $sql = "UPDATE usuario SET estado = 'activo', ultima_actividad = NOW() WHERE id_usuario = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param('i', $id_usuario);
        $stmt->execute();
    }
}

// Obtener lista de usuarios con sus estados
$sql = "SELECT id_usuario, nombre, correo_electronico, estado FROM usuario";
$resultado = $conexion->query($sql);
?>
            <!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>FinzApp Admin Panel</title>
                <link rel="stylesheet" href="estilo.css">
            </head>

            <h2>Gestión de Usuarios</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo Electrónico</th>
                        <th>Estado</th>
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
                            

                            
                            // Mostrar opciones según el estado del usuario
                            if ($row['estado'] == 'activo') {
                                echo "Activo";
                            } elseif ($row['estado'] == 'inactivo') {
                                echo "<form method='POST' action='interfazadmin.php'>
                                          <input type='hidden' name='id_usuario' value='{$row['id_usuario']}'>
                                          <input type='hidden' name='accion' value='activar'>
                                          <button type='submit' class='activar'>Activar</button>
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

        <div
        class="container">
        <a href="../interfazAdmin.php" class="btn btn-dark boton">Regresar</a>
        <a href="excel.php" class="btn btn-success boton">Generar excel</a>
        <a href="" class=" btn btn-warning boton" onclick="window.print()">Imprimir</a>
    </div>
</body>
</html>