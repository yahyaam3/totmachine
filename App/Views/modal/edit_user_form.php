<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <!-- Tailwind CSS desde CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full relative">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit User</h2>
        <form id="edit-user-form" data-user-id="<?= $user['id_user']; ?>" class="space-y-4">
            <div>
                <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
                <input type="text" name="name" id="name" value="<?= $user['name']; ?>" 
                    class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500 text-gray-800" required>
            </div>

            <div>
                <label for="surname" class="block text-gray-700 font-medium mb-2">Surname</label>
                <input type="text" name="surname" id="surname" value="<?= $user['surname']; ?>" 
                    class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500 text-gray-800" required>
            </div>

            <div>
                <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                <input type="email" name="email" id="email" value="<?= $user['email']; ?>" 
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
                <button type="button" class="delete-user bg-red-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500" 
                    data-user-id="<?= $user['id_user']; ?>">
                    Delete
                </button>
            </div>
        </form>
    </div>
</body>

</html>
