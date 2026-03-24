<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar ubicación</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Leaflet CSS local -->
    <link rel="stylesheet" href="/leaflet/leaflet.css"/>

    <style>
        body {
            font-family: Arial;
            margin: 0;
        }

        #map {
            height: 70vh;
            width: 100%;
        }

        .container {
            padding: 10px;
        }

        input {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            margin-bottom: 10px;
        }

        button {
            width: 100%;
            padding: 15px;
            font-size: 18px;
            background: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">Comparte tu ubicación</h2>

<div id="map"></div>

<div class="container">
    <input type="text" id="clave" placeholder="Ingresa tu clave de trabajador">
    <button onclick="guardarUbicacion()">Enviar ubicación</button>
</div>

<!-- Leaflet JS local -->
<script src="/leaflet/leaflet.js"></script>

<script>
let map = L.map('map').setView([19.4326, -99.1332], 13);
let marker;
let lat, lon;

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

// 🔥 Obtener ubicación automática
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {

        lat = position.coords.latitude;
        lon = position.coords.longitude;

        map.setView([lat, lon], 16);

        marker = L.marker([lat, lon]).addTo(map)
            .bindPopup("Tu ubicación").openPopup();

    }, function(error) {
        console.error(error);
        alert("No se pudo obtener tu ubicación. Activa permisos.");
    });
} else {
    alert("Tu navegador no soporta geolocalización");
}

// 🔥 Enviar datos
function guardarUbicacion() {

    const clave = document.getElementById("clave").value.trim();

    if (!clave) {
        alert("Ingresa tu clave");
        return;
    }

    if (!lat || !lon) {
        alert("Ubicación no disponible aún");
        return;
    }

    fetch('/api/guardar-ubicacion', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            clave: clave,
            lat: lat,
            lon: lon
        })
    })
    .then(res => res.json())
    .then(data => {
        alert("Ubicación enviada correctamente");
        console.log(data);
    })
    .catch(err => {
        console.error(err);
        alert("Error al enviar");
    });
}
</script>

</body>
</html>