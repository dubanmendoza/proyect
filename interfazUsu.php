<?php
session_start();
if (!isset($_SESSION['nombre'])) {
    $_SESSION['nombre'] = "Usuario"; // Nombre por defecto si no está definido
}

// Procesar la subida del archivo
$uploadDir = 'uploads/';
$defaultImage = 'default.jpg'; // Imagen predeterminada
$userImage = $uploadDir . $defaultImage;

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true); // Crear el directorio si no existe
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['imagen'])) {
    $uploadFile = $uploadDir . $_SESSION['nombre'] . "" . basename($_FILES['imagen']['name']);
    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadFile)) {
        $_SESSION['imagen'] = $uploadFile; // Guardar la ruta en la sesión
    } else {
        $mensaje = "Error al subir el archivo.";
    }
}

// Cargar la imagen del usuario si está disponible
if (isset($_SESSION['imagen']) && file_exists($_SESSION['imagen'])) {
    $userImage = $_SESSION['imagen'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinzApp Dashboard</title>
    <link rel="stylesheet" href="css/interusu.css">
    <!-- Agregar el enlace a Bootstrap 4 (puedes usar la versión 5 si lo prefieres) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="dashboard">
        <!-- Barra lateral de navegación -->
        <nav class="sidebar">
            <h2>FinzApp</h2>
            <div class="profile-container">
                <!-- Nombre del usuario con estilo Bootstrap -->
                <div class="profile-name  font-weight-bold"><?php echo htmlspecialchars($_SESSION['nombre']); ?></div>
                <!-- Imagen de perfil -->
                <div class="profile-pic">
                    <img src="<?php echo htmlspecialchars($userImage); ?>" alt="Foto de perfil">
                </div>
                <!-- Formulario para subir archivo -->
                <div class="upload-form">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <label for="imagen" class="upload-label">Subir Foto</label>
                        <input type="file" name="imagen" id="imagen" accept="image/*" onchange="this.form.submit()">
                    </form>
                </div>
            </div>
            <ul>
                <li><a href="?section=ingresos">Ingresos</a></li>
                <li><a href="?section=gastos">Gastos</a></li>
                <li><a href="?section=balance">Balance</a></li>
                <li><a href="?section=metas">Metas</a></li>
                <li><a href="?section=pagos">Pagos</a></li>
                <li><a href="cerrar_sesion.php" class="cerrar-sesion">Cerrar Sesión</a></li>

            </ul>
        </nav>

        <!-- Contenido principal -->    
        <div class="content">
            <?php
            // Mostrar diferentes secciones según la URL
            if (isset($_GET['section'])) {
                $section = $_GET['section'];
                switch ($section) {
                    case 'ingresos':
                        include 'ingresos.php';
                        break;
                    case 'gastos':
                        include 'gastos.php';
                        break;
                    case 'balance':
                        include 'balance.php';
                        break;
                    case 'metas':
                        include 'metas.php';
                        break;
                    case 'pagos':
                        include 'pagos.php';
                        break;
                    default:
                        echo "<h2>Sección no válida</h2>";
                }
            } else {
                // Si no hay sección, mostrar una página de bienvenida
                echo "<h2>Bienvenido a FinzApp</h2>";
            }
            ?>
        </div>
    </div>

    <!-- Agregar los scripts de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
