<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Maintenance</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full relative max-h-[90vh] overflow-y-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Add Maintenance</h2>
        
        <form id="add-maintenance-form">
            <div class="mb-4">
                <label for="type" class="block text-gray-700 font-medium mb-2">Type</label>
                <select name="type" id="type" class="border border-gray-300 rounded-lg w-full p-3" required>
                    <option value="PREVENTIVE">Preventive</option>
                    <option value="CORRECTIVE">Corrective</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea name="description" id="description" class="border border-gray-300 rounded-lg w-full p-3" required></textarea>
            </div>

            <div class="mb-4">
                <label for="date" class="block text-gray-700 font-medium mb-2">Date</label>
                <input type="date" name="date" id="date" class="border border-gray-300 rounded-lg w-full p-3" required>
            </div>

            <div class="mb-4">
                <label for="time_spent" class="block text-gray-700 font-medium mb-2">Time Spent (hours)</label>
                <input type="number" name="time_spent" id="time_spent" class="border border-gray-300 rounded-lg w-full p-3" required>
            </div>

            <div class="mb-4">
                <label for="machine_id" class="block text-gray-700 font-medium mb-2">Machine ID</label>
                <input type="number" name="machine_id" id="machine_id" class="border border-gray-300 rounded-lg w-full p-3" required>
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700">
                    Create
                </button>
                <button type="button" class="close-modal bg-gray-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-700">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</body>
</html>