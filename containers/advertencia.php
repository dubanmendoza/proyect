<div id="recommendationsPage" class="recommendations-section">
    <h2>Recomendaciones</h2>
    <p><strong>¡Aviso importante!</strong></p>
    <p>El usuario que no inicie sesión durante 90 días (3 meses) se le inactivará la cuenta y solo mediante un correo al administrador se le volverá a activar.</p>
    <p>Y si su cuenta sigue inactiva durante 120 días (4 meses) su cuenta será borrada del sistema.</p>
    <button type="button" class="back-button" aria-label="Volver a la página anterior" onclick="window.history.back()">Volver</button>
</div>

<style>
/* Contenedor principal */
.recommendations-section {
  background: linear-gradient(145deg, #0056b3, #2ECC71); /* Degradado atractivo */
  color: #ffffff;
  padding: 40px 25px;
  text-align: center;
  font-family: 'Roboto', sans-serif;
  border-radius: 20px;
  box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.2);
  max-width: 850px;
  margin: 40px auto;
  position: relative;
  overflow: hidden;
}

/* Título */
.recommendations-section h2 {
  color: #FFD700; /* Color dorado */
  margin-bottom: 20px;
  font-size: 2.8em;
  text-transform: uppercase;
  font-weight: bold;
  letter-spacing: 2px;
  text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
  border-bottom: 3px solid #FFD700;
  display: inline-block;
  padding-bottom: 10px;
}

/* Párrafos */
.recommendations-section p {
  font-size: 1.2em;
  line-height: 1.8;
  color: #ffffff;
  margin-bottom: 20px;
  text-align: left;
  font-weight: 400;
  padding-left: 20px;
  position: relative;
}


/* Animación del contenedor */
.recommendations-section {
  animation: fadeIn 1.5s ease-in-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
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
