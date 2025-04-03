<?php include "shared/header.php" ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mapa con Marcador</title>
  
  <!-- Incluir CSS de Bootstrap -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Incluir CSS de Leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
</head>
<body>

  <div class="container mt-5">
    <div class="row">
      <div class="col-12">
        <h3>Ubicación en el Mapa</h3>
        <div id="map"></div>
      </div>
    </div>
    
    <!-- Tarjeta con la información del marcador -->
    <div class="row mt-3">
      <div class="col-md-6">
        <div class="info-card">
          <div class="d-flex align-items-center">
            <img src="img/LogoR.png" alt="Logo">
            <div>
              <h5>La Galleta Segura</h5>
              <p><strong>Dirección:</strong> Guadalupe, Enfrente a AutoMercado Guadalupe</p>
              <p><strong>Teléfono:</strong> +506 40405222</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Incluir JavaScript de Bootstrap y Leaflet -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  
  <!-- Incluir JavaScript de Leaflet -->
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

  <script>
    // Crear el mapa centrado en las coordenadas proporcionadas
    var map = L.map('map').setView([9.952374703159322, -84.04578279199418], 13); // Coordenadas específicas

    // Agregar capa de mapa (usamos OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Agregar marcador en la ubicación exacta
    var marker = L.marker([9.952374703159322, -84.04578279199418]).addTo(map);
    
    // Definir el contenido del popup del marcador
    var popupContent = `
      <div class="d-flex align-items-center">
        <img src="img/LogoR.png" alt="Logo" class="rounded-circle" style="width: 50px; height: 50px;"> 
        <div>
          <h5>La Galleta Segura</h5>
          <p><strong>Dirección:</strong> Guadalupe, Enfrente a AutoMercado Guadalupe</p>
          <p><strong>Teléfono:</strong> +506 40405222</p>
        </div>
      </div>
    `;
    marker.bindPopup(popupContent).openPopup();
  </script>
  
</body>
</html>

<?php include "shared/footer.php" ?>
