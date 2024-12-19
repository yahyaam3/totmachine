<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Maintenance</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900 min-h-screen flex items-center justify-center">
    <div class="max-w-lg mx-auto bg-white shadow-lg rounded-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Maintenance</h2>
        <form method="POST" action="/maintenance/update" class="space-y-4">
            <input type="hidden" name="id" value="<?= $maintenance['id_maintenance'] ?>">

            <div>
                <label for="type" class="block text-gray-700 font-medium mb-2">Type</label>
                <select name="type" id="type" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500 text-gray-800" required>
                    <option value="PREVENTIVE" <?= $maintenance['type'] === 'PREVENTIVE' ? 'selected' : ''; ?>>Preventive</option>
                    <option value="CORRECTIVE" <?= $maintenance['type'] === 'CORRECTIVE' ? 'selected' : ''; ?>>Corrective</option>
                </select>
            </div>

            <div>
                <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea name="description" id="description" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500 text-gray-800" required><?= htmlspecialchars($maintenance['description'], ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>

            <div>
                <label for="date" class="block text-gray-700 font-medium mb-2">Date</label>
                <input type="date" name="date" id="date" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500 text-gray-800" value="<?= htmlspecialchars($maintenance['date'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>

            <div>
                <label for="time_spent" class="block text-gray-700 font-medium mb-2">Time Spent (hours)</label>
                <input type="number" name="time_spent" id="time_spent" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500 text-gray-800" value="<?= htmlspecialchars($maintenance['time_spent'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>

            <div>
                <label for="machine_id" class="block text-gray-700 font-medium mb-2">Machine ID</label>
                <input type="number" name="machine_id" id="machine_id" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500 text-gray-800" value="<?= htmlspecialchars($maintenance['id_machine'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Update Maintenance</button>
        </form>
    </div>
</body>

</html>
