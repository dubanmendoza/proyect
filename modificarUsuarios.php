<?php 
    include "models/conexion.php";

    // Obtiene el ID del usuario desde la URL
    $id = $_GET['id_usuario'] ?? null;

    // Verifica que el ID esté presente y busca el usuario
    if ($id) {
        $sql = "SELECT * FROM usuario WHERE id_usuario = '$id'";
        $resultado = $conexion->query($sql);
        $row = $resultado->fetch_array(MYSQLI_ASSOC);
    } else {
        echo '<div class="alert alert-danger">ID de usuario no proporcionado</div>';
        exit;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <form action="" method="POST">
        <p class="h1">Modificar Usuario</p>

        <?php
            // Incluye el controlador de modificación
            include "controllers/modificar.php";
        ?>

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" class="form-control" id="nombre" value="<?php echo $row['nombre']; ?>" name="nom" required>
        </div>
        <div class="mb-3">
            <label for="correo_electronico" class="form-label">Correo Electrónico:</label>
            <input type="email" class="form-control" id="correo_electronico" value="<?php echo $row['correo_electronico']; ?>" name="cor" required>
        </div>
        <div class="mb-3">
            <label for="contrasena" class="form-label">Contraseña:</label>
            <input type="password" class="form-control" id="contrasena" value="<?php echo $row['contrasena']; ?>" name="con" required>
        </div>
        <div class="mb-3">
            <label for="id_rol" class="form-label">Rol:</label>
            <select class="form-control" id="id_rol" name="rol">
                <option value="" <?php echo ($row['id_rol'] === null) ? 'selected' : ''; ?>>Sin asignar</option>
                <?php
                    // Consulta los roles disponibles en la tabla roles
                    $roles = $conexion->query("SELECT * FROM roles");
                    while ($rol = $roles->fetch_array(MYSQLI_ASSOC)) {
                        $selected = ($rol['id_rol'] == $row['id_rol']) ? 'selected' : '';
                        echo "<option value='{$rol['id_rol']}' $selected>{$rol['nombre_rol']}</option>";
                    }
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary" name="modificar" value="ok">Modificar Registro</button>
    </form>
</body>
</html>
