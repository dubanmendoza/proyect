<?php 
if (!empty($_POST['modificar'])) {
    // Verifica que los campos necesarios no estén vacíos
    if (!empty($_POST['nom']) && !empty($_POST['cor']) && !empty($_POST['con'])) {
        // Recibe los datos del formulario
        $nombre = $_POST['nom'];
        $correo = $_POST['cor'];
        $contrasena = $_POST['con'];
        $rol = $_POST['rol'] ; 

        // Obtiene el ID del usuario desde la URL                                   
        $id = $_GET['id_usuario']  ;

        if ($conexion && $id) {
            // Consulta para actualizar los datos del usuario
            $sql = "UPDATE usuario 
                    SET nombre = '$nombre', correo_electronico = '$correo', contrasena = '$contrasena', id_rol = '$rol' 
                    WHERE id_usuario = '$id'";
            $resultado = mysqli_query($conexion, $sql);

            // Mensaje de éxito
            if ($resultado) {
                echo '<div class="alert alert-success">Registro modificado con éxito</div>';
            } else {
                echo '<div class="alert alert-danger">Error al modificar el registro</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Error de conexión o ID no válido</div>';
        }
    } else {
        echo '<div class="alert alert-warning">Por favor, completa todos los campos</div>';
    }
}
?>
