<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Machine Detail</title>
    <!-- Tailwind CSS from CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body class="bg-gray-100 text-gray-900 min-h-screen">
    <!-- Main container -->
    <div class="container mx-auto px-6 py-8" role="main" aria-labelledby="machine-heading">
        <div class="bg-white shadow-lg rounded-lg p-8 max-w-lg mx-auto">
            <!-- Page heading -->
            <h2 class="text-2xl font-bold mb-6 text-gray-800" id="machine-heading">Machine Detail</h2>

            <!-- Machine details -->
            <div class="mb-4">
                <p><strong class="text-gray-700">Model:</strong> <?= htmlspecialchars($machine['model'], ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong class="text-gray-700">Manufacturer:</strong> <?= htmlspecialchars($machine['manufacturer'], ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong class="text-gray-700">Serial:</strong> <?= htmlspecialchars($machine['serial_number'], ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong class="text-gray-700">Start Date:</strong> <?= htmlspecialchars($machine['start_date'], ENT_QUOTES, 'UTF-8'); ?></p>
            </div>

            <!-- Machine image display -->
            <?php if (!empty($machine['image'])): ?>
                <div class="mb-4">
                    <img src="/<?= htmlspecialchars($machine['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Machine Image" class="w-full max-w-xs h-auto object-cover border rounded-lg">
                </div>
            <?php endif; ?>

            <!-- QR Code display -->
            <div class="mb-4">
                <p class="text-gray-700 font-medium">QR Code:</p>
                <img src="/<?= htmlspecialchars($qr_path, ENT_QUOTES, 'UTF-8'); ?>" alt="QR Code" class="w-32 h-32 border mt-2">
            </div>

            <!-- Map display with Leaflet JS -->
            <?php if (!empty($machine['latitude']) && !empty($machine['longitude'])): ?>
                <div class="mt-6">
                    <p class="text-gray-700 font-medium mb-2">Location:</p>
                    <div id="map" class="w-full h-64 rounded-lg border" aria-label="Machine location on map"></div>
                </div>
            <?php endif; ?>

            <!-- PDF download button -->
            <a href="/maintenance/downloadpdf/<?= htmlspecialchars($machine['id_machine'], ENT_QUOTES, 'UTF-8'); ?>"
               class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 inline-block mt-6"
               aria-label="Download machine maintenance PDF">
                Download Maintenance PDF
            </a>
        </div>
    </div>

    <!-- Leaflet map initialization if coordinates exist -->
    <?php if (!empty($machine['latitude']) && !empty($machine['longitude'])): ?>
        <script>
            // Initialize the Leaflet map
            const map = L.map('map').setView([<?= $machine['latitude']; ?>, <?= $machine['longitude']; ?>], 13);

            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Add a marker at the machine's location
            L.marker([<?= $machine['latitude']; ?>, <?= $machine['longitude']; ?>]).addTo(map)
                .bindPopup("<?= htmlspecialchars($machine['model'], ENT_QUOTES, 'UTF-8'); ?>")
                .openPopup();
        </script>
    <?php endif; ?>
</body>

</html>
