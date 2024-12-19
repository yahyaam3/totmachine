<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Machines</title>
    <!-- Tailwind CSS desde CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body class="bg-gray-100 text-gray-900 min-h-screen">
    <div class="container mx-auto px-6 py-8">
        <div class="bg-white shadow-lg rounded-lg p-8">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Machines</h2>

            <!-- Botón Añadir Máquina -->
            <?php if ($_SESSION['user_role'] == 'SUPERVISOR' || $_SESSION['user_role'] == 'ADMINISTRATOR'): ?>
                <button type="button" class="add-machine bg-green-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-700">
                    Add Machine
                </button>
            <?php endif; ?>

            <!-- Campo de búsqueda -->
            <input type="text" id="machineSearch" placeholder="Search machines..." 
                class="border border-gray-300 rounded-lg p-3 ml-4 w-1/2 focus:ring-blue-500 focus:border-blue-500 text-gray-800">

            <!-- Resultados de búsqueda -->
            <div id="searchResults" class="mt-4"></div>

            <!-- Mapa Leaflet -->
            <div id="map" class="z-0 w-full h-96 mt-6 rounded-lg border"></div>

            <!-- Tabla de Máquinas -->
            <table class="w-full mt-6 border border-gray-300 rounded-lg shadow-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr class="text-left">
                        <th class="p-4 font-medium">Model</th>
                        <th class="p-4 font-medium">Manufacturer</th>
                        <th class="p-4 font-medium">Serial</th>
                        <th class="p-4 font-medium">Technician</th>
                        <th class="p-4 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody id="machinesTable" class="divide-y divide-gray-200">
                    <?php foreach ($machines as $m): ?>
                        <!-- machines/list.php -->
                        <tr data-machine-id="<?= $m['id_machine']; ?>">
                            <td class="p-4 text-gray-700"><?= $m['model']; ?></td>
                            <td class="p-4 text-gray-700"><?= $m['manufacturer']; ?></td>
                            <td class="p-4 text-gray-700"><?= $m['serial_number']; ?></td>
                            <td class="p-4 text-gray-700"><?= $m['technician_username']; ?></td>
                            <td class="p-4 space-x-4">
                                <a href="/machines/detail/<?= $m['id_machine']; ?>" class="text-blue-600 hover:underline">Detail</a>
                                <?php if ($_SESSION['user_role'] == 'SUPERVISOR' || $_SESSION['user_role'] == 'ADMINISTRATOR'): ?>
                                    <a href="#" class="edit-machine text-yellow-600 hover:underline" data-machine-id="<?= $m['id_machine']; ?>">Edit</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Inicializar mapa Leaflet
        const map = L.map('map').setView([0, 0], 2); // Centrado global inicial
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
        }).addTo(map);

        // Agregar marcadores al mapa
        <?php foreach ($machines as $m): ?>
            <?php if (!empty($m['latitude']) && !empty($m['longitude'])): ?>
                L.marker([<?= $m['latitude']; ?>, <?= $m['longitude']; ?>])
                    .addTo(map)
                    .bindPopup("<strong><?= $m['model']; ?></strong><br><?= $m['manufacturer']; ?>");
            <?php endif; ?>
        <?php endforeach; ?>

        // Ajustar vista del mapa para mostrar todos los marcadores
        const bounds = L.latLngBounds([]);
        document.querySelectorAll('.leaflet-marker-icon').forEach(marker => {
            const coords = marker._leaflet_pos; // Obtener coordenadas del marcador
            bounds.extend(coords);
        });
        if (bounds.isValid()) {
            map.fitBounds(bounds);
        }

        // Búsqueda de máquinas
        document.getElementById('machineSearch').addEventListener('input', function () {
            let q = this.value;
            if (q.length >= 3) {
                fetch('/ajax/search-machines?q=' + encodeURIComponent(q))
                    .then(res => res.json())
                    .then(data => {
                        let html = '<ul class="bg-white border border-gray-300 rounded-lg shadow-md">';
                        data.machines.forEach(m => {
                            html += `<li class="p-3 border-b"><a href="/machines/detail/${m.id_machine}" class="text-blue-600 hover:underline">${m.model} - ${m.manufacturer}</a></li>`;
                        });
                        html += '</ul>';
                        document.getElementById('searchResults').innerHTML = html;
                    });
            } else {
                document.getElementById('searchResults').innerHTML = '';
            }
        });
    </script>
</body>

</html>
