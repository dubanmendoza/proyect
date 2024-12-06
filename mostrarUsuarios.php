<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a53887caa8.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php
    include "Models/conexion.php";
    $where = "";

    // Verificar si se carga o no la información
    if (!empty($_POST)) {
        $valor = $_POST['nombre'];
        if (!empty($valor)) {
            $where = "WHERE nombre LIKE '%$valor%'";
        }
    }

    // Consulta SQL para obtener los usuarios
    $sql = "SELECT * FROM usuario $where";
    $resultado = $conexion->query($sql);
    ?>

    <p class="h1">Lista de Usuarios</p>
    <div class="row" style="float:left">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="mb-3 mt-3 p-1">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre">
            </div>
            <div class="mb-2 mt-2 p-1">
                <input type="submit" class="form-control btn btn-info" id="enviar" name="enviar" value="Buscar">
            </div>
        </form>
    </div>

    <div class="container mt-3">
        <table class="table table-dark">
            <thead>
                <tr>
                    <th>ID Usuario</th>
                    <th>Nombre Completo</th>
                    <th>Correo Electrónico</th>
                    <th>Contraseña</th>
                    <th>Rol</th>
                    <th>Acción</th>
                </tr>
            </thead>

            <tbody>
                <?php
                // Verifica si hay resultados en la consulta
                if ($resultado->num_rows > 0) {
                    while ($row = $resultado->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?php echo $row['id_usuario']; ?></td>
                            <td><?php echo $row['nombre']; ?></td>
                            <td><?php echo $row['correo_electronico']; ?></td>
                            <td><?php echo $row['contrasena']; ?></td>
                            <td><?php echo ($row['id_rol'] === null) ? 'selected' : ''; ?></td>
                            <td>
                                <?php
                                // Consulta el nombre del rol desde la tabla roles
                                $rol_id = $row['id_rol'];
                                $rol_query = $conexion->query("SELECT nombre_rol FROM roles WHERE id_rol = '$rol_id'");
                                $rol = $rol_query->fetch_assoc();
                                echo $rol ? $rol['nombre_rol'] : 'Sin asignar';
                                ?>
                            </td>
                            <td>
                                <a href="modificarUsuarios.php?id_usuario=<?php echo $row["id_usuario"]; ?>">
                                    <i class='fas fa-edit' style='font-size:36px; color:white'></i>
                                </a>
                                <a href="#" data-href="controllers/eliminar.php?id_usuario=<?php echo $row["id_usuario"]; ?>"
                                   data-bs-toggle="modal" data-bs-target="#confirmar-delete">
                                    <i class='fas fa-trash-alt' style='font-size:36px; color:red'></i>
                                </a>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
                <?php include "modal.php"; ?>
            </tbody>
        </table>
    </div>
    
</body>
</html>