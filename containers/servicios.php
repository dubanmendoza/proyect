<div id="featuresPage" class="services-section">
    <h2>Servicios</h2>
    <ul>
        <li><strong>Gestión de ingresos:</strong> Registra y ordena todos tus ingresos para un control detallado de tu presupuesto.</li>
        <li><strong>Gestión de gastos:</strong> Registra y ordena todos tus gastos para un control detallado de tu presupuesto.</li>
        <li><strong>metas:</strong> Crea metas financieras a corto plazo.</li>
        <li><strong>Balance:</strong> Revisa en el balance tu estado financiero de forma sencilla.</li>
        <li><strong>Pagos:</strong> Registra y ordena todos tus pagos para un control detallado de lo que debes.</li>
        <li><strong>Informes:</strong> Genera informes en excel o pdf del servivio solicitado.</li>
    </ul>
    <button type="button" class="back-button" aria-label="Volver a la página anterior" onclick="window.history.back()">Volver</button>
</div>

<style>
/* Contenedor principal */
.services-section {
  background: linear-gradient(135deg, #4CAF50, #2196F3); /* Degradado atractivo */
  color: #f9f9f9; /* Texto claro */
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
.services-section h2 {
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

/* Lista */
.services-section ul {
  list-style: none;
  padding: 0;
  margin: 25px 0;
}

.services-section li {
  font-size: 1.2em;
  line-height: 1.8;
  color: #ffffff;
  margin-bottom: 15px;
  text-align: left;
  padding-left: 25px;
  position: relative;
  font-weight: 500;
}

/* Icono decorativo */
.services-section li::before {
  content: '✓'; /* Icono de check */
  color: #FFD700;
  font-weight: bold;
  position: absolute;
  left: 0;
  top: 0;
  transform: translateY(5px);
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
/* Animación del contenedor */
.services-section {
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
</style>
