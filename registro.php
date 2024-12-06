<!-- register.html -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="css/formularios.css">
</head>
<body>

<div class="register-form">
    

    

    <form action="" method="POST">
    <h2>Registrarse</h2>

    <?php include_once 'models/conexion.php';
    include_once 'controllers/usuario.php'; 
    ?>
        <label for="newName">Nombre Completo:</label>
        <input type="text" id="newName" name="nom" required>
        
        <label for="newEmail">Correo electrónico:</label>
        <input type="email" id="newEmail" name="cor" required>
        
        <label for="newPassword">Contraseña:</label>
        <input type="password" id="newPassword" name="con" required>
        
        <button type="submit" name="registrar" value="ok">Registrarse</button>
        <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
    </form>

    
    <button type="button" class="back-button" onclick="window.history.back()">Volver</button>
</div>

</body>
</html>
