<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <!-- Tailwind CSS from CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full relative max-h-[90vh] overflow-y-auto" role="main" aria-labelledby="form-heading">
        <h2 class="text-2xl font-bold text-gray-800 mb-6" id="form-heading">Edit User</h2>
        
        <!-- edit_user_form.php -->
        <form id="edit-user-form" data-user-id="<?= htmlspecialchars($user['id_user'], ENT_QUOTES, 'UTF-8'); ?>">
            <!-- Name Field -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
                <input type="text" name="name" id="name" value="<?= htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8'); ?>" 
                    class="border border-gray-300 rounded-lg w-full p-3" required>
            </div>

            <!-- Surname Field -->
            <div>
                <label for="surname" class="block text-gray-700 font-medium mb-2">Surname</label>
                <input type="text" name="surname" id="surname" value="<?= htmlspecialchars($user['surname'], ENT_QUOTES, 'UTF-8'); ?>" 
                    class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500 text-gray-800" required aria-required="true">
            </div>

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8'); ?>" 
                    class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500 text-gray-800" required aria-required="true">
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-4">
                <button type="submit" 
                    class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500" aria-label="Update user details">
                    Update
                </button>
                
                <button type="button" class="close-modal bg-gray-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500" aria-label="Cancel editing">
                    Cancel
                </button>
                
                <button type="button" class="delete-user bg-red-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500" 
                    data-user-id="<?= htmlspecialchars($user['id_user'], ENT_QUOTES, 'UTF-8'); ?>" aria-label="Delete this user">
                    Delete
                </button>
            </div>
        </form>
    </div>
</body>

</html>
