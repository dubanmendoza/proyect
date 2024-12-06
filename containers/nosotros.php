<div id="aboutPage" class="about-section">
    <h2>Sobre Nosotros</h2>
    <p>En FinzApp, estamos comprometidos a ayudarte a gestionar tus finanzas de manera fácil y eficiente. Nuestra misión es proporcionar una plataforma intuitiva que empodere a las personas para tomar el control de su futuro financiero.</p>
    <p>Somos un grupo de estudiantes apasionados por la tecnología, dedicados a ofrecer herramientas seguras, rápidas y fáciles de usar para que alcances tus metas financieras. Nuestra visión es ser la aplicación financiera preferida a nivel mundial, transformando la forma en que las personas gestionan su dinero, y contribuyendo a una comunidad más informada y preparada para tomar decisiones financieras acertadas.</p>
    <p>Creemos en la transparencia, la simplicidad y la seguridad, valores que guían cada paso que damos. Trabajamos incansablemente para garantizar que tu experiencia con FinzApp sea no solo confiable, sino también enriquecedora. Nuestra plataforma está diseñada para ser accesible tanto para principiantes como para expertos, brindando herramientas personalizables que se adaptan a tus necesidades.</p>
    <p>En FinzApp, entendemos que cada persona tiene diferentes objetivos financieros, por lo que ofrecemos opciones flexibles que te permiten crear un plan que se ajuste a tu estilo de vida y metas a corto, mediano y largo plazo. Ya sea que desees ahorrar para una compra importante, pagar deudas o invertir para tu futuro, estamos aquí para acompañarte en cada paso del camino.</p>
    <p>Nos enorgullece ser una empresa que promueve la educación financiera, ayudando a nuestros usuarios a comprender mejor cómo tomar decisiones informadas que impulsen su bienestar financiero. Creemos que una buena gestión financiera es clave para una vida plena y exitosa.</p>
    <p>Gracias por confiar en FinzApp. Estamos aquí para ayudarte a lograr tus sueños financieros, con la tranquilidad de saber que cuentas con una herramienta robusta, segura y fácil de usar. ¡Empieza hoy mismo a tomar el control de tu futuro financiero con nosotros!</p>
    <button type="button" class="back-button" aria-label="Volver a la página anterior" onclick="window.history.back()">Volver</button>
</div>

<style>
/* Contenedor principal */
.about-section {
  background: linear-gradient(135deg, #4CAF50, #2196F3); /* Degradado atractivo */
  color: #ffffff; /* Texto blanco */
  padding: 40px 30px; /* Espaciado interno */
  border-radius: 20px; /* Bordes redondeados */
  box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2); /* Sombra fuerte */
  max-width: 900px; /* Ancho máximo */
  margin: 40px auto; /* Centrado */
  font-family: 'Roboto', sans-serif; /* Tipografía profesional */
  text-align: justify; /* Texto justificado */
  position: relative;
}

/* Título */
.about-section h2 {
  font-size: 2.8em; /* Tamaño destacado */
  font-weight: bold;
  text-align: center;
  text-transform: uppercase; /* Texto en mayúsculas */
  color: #FFD700; /* Color dorado para resaltar */
  border-bottom: 4px solid #FFD700; /* Línea decorativa */
  display: inline-block;
  padding-bottom: 10px;
  margin-bottom: 25px;
  text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3); /* Sombra en el texto */
}

/* Párrafos */
.about-section p {
  font-size: 1.2em; /* Texto legible */
  line-height: 1.8; /* Espaciado entre líneas */
  margin-bottom: 20px;
  text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2); /* Sombra ligera */
}


/* Animación de entrada */
.about-section {
  animation: fadeIn 1.5s ease-in-out; /* Efecto de aparición */
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
