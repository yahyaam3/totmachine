<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full relative max-h-[90vh] overflow-y-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Add User</h2>
        
        <form id="add-user-form">
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
                <input type="text" name="name" id="name" class="border border-gray-300 rounded-lg w-full p-3" required>
            </div>

            <div class="mb-4">
                <label for="surname" class="block text-gray-700 font-medium mb-2">Surname</label>
                <input type="text" name="surname" id="surname" class="border border-gray-300 rounded-lg w-full p-3" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                <input type="email" name="email" id="email" class="border border-gray-300 rounded-lg w-full p-3" required>
            </div>

            <div class="mb-4">
                <label for="username" class="block text-gray-700 font-medium mb-2">Username</label>
                <input type="text" name="username" id="username" class="border border-gray-300 rounded-lg w-full p-3" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                <input type="password" name="password" id="password" class="border border-gray-300 rounded-lg w-full p-3" required>
            </div>

            <div class="mb-4">
                <label for="role" class="block text-gray-700 font-medium mb-2">Role</label>
                <select name="role" id="role" class="border border-gray-300 rounded-lg w-full p-3" required>
                    <option value="TECHNICIAN">Technician</option>
                    <option value="SUPERVISOR">Supervisor</option>
                    <option value="ADMINISTRATOR">Administrator</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="avatar" class="block text-gray-700 font-medium mb-2">Avatar</label>
                <input type="file" name="avatar" id="avatar" accept="image/*" class="border border-gray-300 rounded-lg w-full p-3">
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700">
                    Add
                </button>
                <button type="button" class="close-modal bg-gray-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-700">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</body>
</html>