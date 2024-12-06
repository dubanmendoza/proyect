<link rel="stylesheet" href="css/formularios.css">
<div class="login-form">

    <form action="controllers/validar_login.php" method="POST">
        <h2>Iniciar Sesión</h2>

        <!-- Mostrar mensaje de error -->
        <?php
        if (isset($_GET['error'])) {
            echo '<div class="error-message">' . htmlspecialchars($_GET['error']) . '</div>';
        }
        ?>

        <label for="email">Correo electrónico:</label>
        <input type="text" id="email" name="cor" required>
        
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="con" required>
        
        <button type="submit" name="iniciar_sesion">Entrar</button>
        <p>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
    </form>

    <button type="button" class="back-button" onclick="window.history.back()">Volver</button>

</div>


