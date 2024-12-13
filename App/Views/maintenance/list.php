<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance</title>
    <!-- Tailwind CSS desde CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900 min-h-screen">
    <div class="container mx-auto px-6 py-8">
        <div class="bg-white shadow-lg rounded-lg p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Maintenance</h2>

            <!-- Botón para añadir mantenimiento -->
            <a href="/maintenance/add" class="bg-green-600 text-white px-5 py-3 rounded-lg font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                Add Maintenance
            </a>

            <!-- Tabla de mantenimiento -->
            <table class="w-full mt-6 border border-gray-300 rounded-lg overflow-hidden shadow-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr class="text-left">
                        <th class="p-4 font-medium">Type</th>
                        <th class="p-4 font-medium">Description</th>
                        <th class="p-4 font-medium">Date</th>
                        <th class="p-4 font-medium">Time Spent</th>
                        <th class="p-4 font-medium">Machine</th>
                        <th class="p-4 font-medium">User</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($maintenance as $m): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="p-4 text-gray-700"><?= $m['type']; ?></td>
                            <td class="p-4 text-gray-700"><?= $m['description']; ?></td>
                            <td class="p-4 text-gray-700"><?= $m['date']; ?></td>
                            <td class="p-4 text-gray-700"><?= $m['time_spent']; ?>h</td>
                            <td class="p-4 text-gray-700"><?= $m['machine_model']; ?></td>
                            <td class="p-4 text-gray-700"><?= $m['user_username']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
