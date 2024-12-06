<?php
include_once '../Models/conexion.php';
session_start();

if (isset($_POST['cor']) && isset($_POST['con'])) {
    function validar($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $usu = validar($_POST['cor']);
    $pass = validar($_POST['con']);

    if (empty($usu)) {
        header('Location: ../login.php?error=Usuario requerido');
        exit();
    } elseif (empty($pass)) {
        header('Location: ../login.php?error=Contraseña requerida');
        exit();
    }

    // Verificar si el usuario existe
    $sql = "SELECT id_usuario, nombre, correo_electronico, contrasena, id_rol, estado, ultima_actividad FROM usuario WHERE correo_electronico = '$usu'";
    $resultado = mysqli_query($conexion, $sql);

    if ($resultado && mysqli_num_rows($resultado) === 1) {
        $row = mysqli_fetch_assoc($resultado);

        // Validar la contraseña en texto plano
        if ($row['contrasena'] === $pass) {
            // Calcular días de inactividad
            $dias_inactividad = (strtotime("now") - strtotime($row['ultima_actividad'])) / 86400; // Convertir a días

            // Manejar estados según los días de inactividad
            if ($dias_inactividad > 120) {
                // Eliminar la cuenta después de 120 días de inactividad
                $sql_delete = "DELETE FROM usuario WHERE id_usuario = '" . $row['id_usuario'] . "'";
                $conexion->query($sql_delete);
                header('Location: ../login.php?error=Usuario no encontrado. Tu cuenta ha sido eliminada por inactividad.');
                exit();
            } elseif ($dias_inactividad > 90) {
                // Cambiar el estado a inactivo si supera 90 días
                if ($row['estado'] !== 'inactivo') {
                    $sql_update_estado = "UPDATE usuario SET estado = 'inactivo' WHERE id_usuario = '" . $row['id_usuario'] . "'";
                    $conexion->query($sql_update_estado);
                }
                header('Location: ../login.php?error=Tu cuenta está inactiva. Por favor, contacta al administrador.');
                exit();
            }

            // Validar el estado del usuario
            if ($row['estado'] === 'bloqueado') {
                header('Location: ../login.php?error=Tu cuenta está bloqueada. Contacta al administrador.');
                exit();
            }

            // Si el usuario está activo, iniciar sesión
            $_SESSION['id_usuario'] = $row['id_usuario'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['id_rol'] = $row['id_rol'];

            // Actualizar estado a 'activo' y última actividad
            $sql_update_estado = "UPDATE usuario SET estado = 'activo', ultima_actividad = NOW() WHERE id_usuario = '" . $row['id_usuario'] . "'";
            $conexion->query($sql_update_estado);

            // Redirección según el rol
            if ($row['id_rol'] == 1) {
                header('Location: ../interfazUsu.php');
            } elseif ($row['id_rol'] == 2) {
                header('Location: ../interfazAdmin.php');
            }
            exit();
        } else {
            // Contraseña incorrecta
            header('Location: ../login.php?error=Usuario o contraseña incorrectos.');
            exit();
        }
    } else {
        // Usuario no encontrado
        header('Location: ../login.php?error=Usuario no encontrado.');
        exit();
    }
}
?>
