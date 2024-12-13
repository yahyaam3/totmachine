<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Machine Detail</title>
    <!-- Tailwind CSS desde CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body class="bg-gray-100 text-gray-900 min-h-screen">
    <div class="container mx-auto px-6 py-8">
        <div class="bg-white shadow-lg rounded-lg p-8 max-w-lg mx-auto">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Machine Detail</h2>
            <div class="mb-4">
                <p><strong class="text-gray-700">Model:</strong> <?= $machine['model']; ?></p>
                <p><strong class="text-gray-700">Manufacturer:</strong> <?= $machine['manufacturer']; ?></p>
                <p><strong class="text-gray-700">Serial:</strong> <?= $machine['serial_number']; ?></p>
                <p><strong class="text-gray-700">Start Date:</strong> <?= $machine['start_date']; ?></p>
            </div>
            <?php if ($machine['image']): ?>
                <div class="mb-4">
                    <img src="/<?= $machine['image']; ?>" alt="Machine Image" class="w-full max-w-xs h-auto object-cover border rounded-lg">
                </div>
            <?php endif; ?>
            <div class="mb-4">
                <p class="text-gray-700 font-medium">QR Code:</p>
                <img src="/<?= $qr_path; ?>" alt="QR Code" class="w-32 h-32 border mt-2">
            </div>

            <!-- Mapa Leaflet -->
            <?php if (!empty($machine['latitude']) && !empty($machine['longitude'])): ?>
                <div class="mt-6">
                    <p class="text-gray-700 font-medium mb-2">Location:</p>
                    <div id="map" class="w-full h-64 rounded-lg border"></div>
                </div>
            <?php endif; ?>

            <a href="/maintenance/downloadpdf/<?= $machine['id_machine']; ?>"
               class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 inline-block mt-6">
                Download Maintenance PDF
            </a>
        </div>
    </div>

    <?php if (!empty($machine['latitude']) && !empty($machine['longitude'])): ?>
        <script>
            // Inicializar el mapa con la ubicación de la máquina
            const map = L.map('map').setView([<?= $machine['latitude']; ?>, <?= $machine['longitude']; ?>], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
            }).addTo(map);

            // Añadir marcador en la ubicación de la máquina
            L.marker([<?= $machine['latitude']; ?>, <?= $machine['longitude']; ?>]).addTo(map)
                .bindPopup("<?= $machine['model']; ?>")
                .openPopup();
        </script>
    <?php endif; ?>
</body>

</html>
