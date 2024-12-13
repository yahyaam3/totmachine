<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Maintenance</title>
    <!-- Tailwind CSS desde CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body class="bg-gray-100 text-gray-900 min-h-screen flex items-center justify-center">
    <div class="max-w-lg mx-auto bg-white shadow-lg rounded-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Add Maintenance</h2>
        <form method="POST" action="/maintenance/store" class="space-y-4">
            <div>
                <label for="type" class="block text-gray-700 font-medium mb-2">Type</label>
                <select name="type" id="type" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500 text-gray-800" required>
                    <option value="PREVENTIVE">Preventive</option>
                    <option value="CORRECTIVE">Corrective</option>
                </select>
            </div>
            <div>
                <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea name="description" id="description" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500 text-gray-800" required></textarea>
            </div>
            <div>
                <label for="date" class="block text-gray-700 font-medium mb-2">Date</label>
                <input type="date" name="date" id="date" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500 text-gray-800" required>
            </div>
            <div>
                <label for="time_spent" class="block text-gray-700 font-medium mb-2">Time Spent (hours)</label>
                <input type="number" name="time_spent" id="time_spent" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500 text-gray-800" required>
            </div>
            <div>
                <label for="machine_id" class="block text-gray-700 font-medium mb-2">Machine ID</label>
                <input type="number" name="machine_id" id="machine_id" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500 text-gray-800" required>
            </div>
            
            <!-- Mapa para seleccionar la ubicación -->
            <div class="mt-6">
                <label class="block text-gray-700 font-medium mb-2">Select Location</label>
                <div id="map" class="w-full h-64 rounded-lg border"></div>
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">
            </div>
            
            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Create
            </button>
        </form>
    </div>

    <script>
        // Inicializar el mapa
        const map = L.map('map').setView([40.416775, -3.703790], 13); // Centrado en Madrid por defecto
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
        }).addTo(map);

        // Añadir marcador
        let marker = L.marker([40.416775, -3.703790], { draggable: true }).addTo(map);

        // Actualizar los campos ocultos cuando se mueve el marcador
        marker.on('dragend', function (e) {
            const position = marker.getLatLng();
            document.getElementById('latitude').value = position.lat;
            document.getElementById('longitude').value = position.lng;
        });

        // Actualizar los valores iniciales de los campos ocultos
        const initialPosition = marker.getLatLng();
        document.getElementById('latitude').value = initialPosition.lat;
        document.getElementById('longitude').value = initialPosition.lng;
    </script>
</body>

</html>
