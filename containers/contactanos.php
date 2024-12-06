<div id="contactPage" class="contact-content">
    <h2>Contáctanos</h2>
    <p>Para consultas, no dudes en ponerte en contacto con nosotros:</p>
    
    <p><strong>Correo Electrónico:</strong> finzapp@gmail.com</p>
    <p><strong>Teléfono:</strong> +57 321 456 78</p>
    <p><strong>Horario de Atención:</strong> Lunes a Viernes de 8:00 a.m. a 6:00 p.m. (GMT-5)</p>

    <p><strong>Síguenos en nuestras redes sociales:</strong></p>
    <ul>
        <li><a href="#" target="_blank">Facebook: FinzApp</a></li>
        <li><a href="#" target="_blank">Instagram: @FinzApp</a></li>
        <li><a href="#" target="_blank">Twitter: @FinzApp</a></li>
    </ul>

    <p>¿Prefieres enviarnos un mensaje? Llena nuestro formulario de contacto <a href="#">aquí</a>.</p>
    <p>Dirección: Calle 123, Oficina 456, Bogotá, Colombia.</p>

    <p>¿Tienes ideas o sugerencias? ¡Nos encantaría escucharte! En FinzApp valoramos tus opiniones para mejorar continuamente nuestra plataforma.</p>

    <p>&copy; 2024 FinzApp. Todos los derechos reservados.</p>
    <p>En FinzApp, tus datos son importantes para nosotros. Puedes consultar nuestra <a href="#">política de privacidad</a> para saber más sobre cómo protegemos tu información.</p>

    <button type="button" class="back-button" aria-label="Volver a la página anterior" onclick="window.history.back()">Volver</button>
</div>

<style>
/* Estilos generales para la sección de contacto */
.contact-content {
    background: linear-gradient(145deg, #0056b3, #2ECC71); /* Degradado atractivo */
    color: #ffffff; /* Texto en blanco */
    padding: 40px; /* Espaciado interno amplio */
    border-radius: 15px; /* Bordes redondeados */
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2); /* Sombra suave */
    max-width: 800px; /* Ancho máximo */
    margin: 50px auto; /* Centrado */
    font-family: 'Montserrat', sans-serif; /* Tipografía moderna */
}

/* Título */
.contact-content h2 {
    font-size: 2.5em; /* Tamaño grande */
    font-weight: bold; /* Negrita */
    text-align: center; /* Centramos el título */
    margin-bottom: 20px; /* Espaciado inferior */
    text-transform: uppercase; /* Texto en mayúsculas */
    letter-spacing: 2px; /* Espaciado entre letras */
    border-bottom: 3px solid #ffffff; /* Línea decorativa */
    display: inline-block;
    padding-bottom: 5px;
}

/* Párrafos */
.contact-content p {
    font-size: 1.2em; /* Tamaño de texto legible */
    line-height: 1.8; /* Espaciado entre líneas */
    margin-bottom: 20px; /* Separación entre párrafos */
}

/* Lista de redes sociales */
.contact-content ul {
    list-style-type: none; /* Sin viñetas */
    padding: 0;
    margin: 20px 0;
}

.contact-content ul li {
    margin: 10px 0;
    font-size: 1.1em;
}

/* Enlaces */
.contact-content a {
    color: #ffcc00; /* Amarillo para los enlaces */
    text-decoration: none; /* Sin subrayado */
    font-weight: bold;
}

.contact-content a:hover {
    text-decoration: underline; /* Subrayado al pasar el ratón */
    color: #ffffff; /* Blanco */
}

/* Animación de entrada */
.contact-content {
    animation: fadeIn 1.5s ease-in-out; /* Entrada suave */
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px); /* Aparece desde abajo */
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Estilo mejorado para el botón de volver en la parte superior izquierda */
.back-button {
    position: absolute; /* Posicionamiento absoluto para fijarlo en la esquina superior izquierda */
    top: 20px; /* Un poco de espacio desde la parte superior */
    left: 20px; /* Un poco de espacio desde la izquierda */
    padding: 10px 20px; /* Espaciado adecuado */
    border: 2px solid #007BFF; /* Borde azul suave */
    border-radius: 5px; /* Bordes más suaves */
    background-color: #ffffff; /* Fondo blanco para hacerlo destacar */
    color: #007BFF; /* Texto azul para armonizar con el borde */
    font-size: 16px; /* Tamaño de texto adecuado */
    font-weight: normal; /* Normal para no sobrecargar el diseño */
    cursor: pointer; /* Manito al pasar el cursor */
    transition: background-color 0.3s ease-in-out, border-color 0.3s ease-in-out; /* Transición suave */
    z-index: 10; /* Asegura que esté por encima de otros elementos */
}

.back-button:hover {
    background-color: #007BFF; /* Fondo azul al hacer hover */
    color: #ffffff; /* Texto blanco al hacer hover */
    border-color: #0056b3; /* Borde más oscuro al hacer hover */
}
</style>

