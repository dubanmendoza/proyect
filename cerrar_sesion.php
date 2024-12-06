<?php
session_start();

if (isset($_SESSION['id_usuario'])) {
    // No cambiar el estado a 'inactivo' al cerrar sesión
    // Solo se destruye la sesión
    session_destroy();
}

header('Location: index'); // Redirigir a la página de inicio
exit();
?>