<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Incident</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full relative max-h-[90vh] overflow-y-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Incident</h2>
        
        <form id="edit-incident-form" data-incident-id="<?= htmlspecialchars($incident['id_incident'], ENT_QUOTES, 'UTF-8'); ?>">
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea name="description" id="description" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500 text-gray-800" required><?= htmlspecialchars($incident['description'], ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>

            <div class="mb-4">
                <label for="priority" class="block text-gray-700 font-medium mb-2">Priority</label>
                <select name="priority" id="priority" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500 text-gray-800" required>
                    <option value="LOW" <?= $incident['priority'] === 'LOW' ? 'selected' : ''; ?>>Low</option>
                    <option value="MEDIUM" <?= $incident['priority'] === 'MEDIUM' ? 'selected' : ''; ?>>Medium</option>
                    <option value="HIGH" <?= $incident['priority'] === 'HIGH' ? 'selected' : ''; ?>>High</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="status" class="block text-gray-700 font-medium mb-2">Status</label>
                <select name="status" id="status" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500 text-gray-800" required>
                    <option value="WAITING" <?= $incident['status'] === 'WAITING' ? 'selected' : ''; ?>>Waiting</option>
                    <option value="IN_PROCESS" <?= $incident['status'] === 'IN_PROCESS' ? 'selected' : ''; ?>>In Process</option>
                    <option value="RESOLVED" <?= $incident['status'] === 'RESOLVED' ? 'selected' : ''; ?>>Resolved</option>
                </select>
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Update
                </button>
                <button type="button" class="close-modal bg-gray-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Cancel
                </button>
                <button type="button" class="delete-incident bg-red-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500" data-incident-id="<?= htmlspecialchars($incident['id_incident'], ENT_QUOTES, 'UTF-8'); ?>">
                    Delete
                </button>
            </div>
        </form>
    </div>
</body>
</html>