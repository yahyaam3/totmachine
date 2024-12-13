<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Machine</title>
    <!-- Tailwind CSS desde CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full relative">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Machine</h2>
        <form id="edit-machine-form" data-machine-id="<?= $machine['id_machine']; ?>" class="space-y-4">
            <div>
                <label for="model" class="block text-gray-700 font-medium mb-2">Model</label>
                <input type="text" name="model" id="model" value="<?= $machine['model']; ?>" 
                    class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500 text-gray-800" required>
            </div>

            <div>
                <label for="manufacturer" class="block text-gray-700 font-medium mb-2">Manufacturer</label>
                <input type="text" name="manufacturer" id="manufacturer" value="<?= $machine['manufacturer']; ?>" 
                    class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500 text-gray-800" required>
            </div>

            <div>
                <label for="serial_number" class="block text-gray-700 font-medium mb-2">Serial Number</label>
                <input type="text" name="serial_number" id="serial_number" value="<?= $machine['serial_number']; ?>" 
                    class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500 text-gray-800" required>
            </div>

            <!-- Botones de acción -->
            <div class="flex space-x-4">
                <button type="submit" 
                    class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Update
                </button>
                <button type="button" class="close-modal bg-gray-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Cancel
                </button>
                <button type="button" class="delete-machine bg-red-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500" 
                    data-machine-id="<?= $machine['id_machine']; ?>">
                    Delete
                </button>
            </div>
        </form>
    </div>
</body>

</html>
