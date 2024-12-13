<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Tailwind CSS desde CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-sm mx-auto bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Login</h2>
        <form method="POST" action="/login" class="space-y-4">
            <!-- Campo Username -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input 
                    type="text" 
                    name="username" 
                    id="username" 
                    class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500 text-gray-800" 
                    required
                >
            </div>
            <!-- Campo Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500 text-gray-800" 
                    required
                >
            </div>
            <!-- Botón Login -->
            <button 
                type="submit" 
                class="bg-blue-600 text-white w-full py-3 rounded-lg font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
                Login
            </button>
        </form>
    </div>
</body>

</html>
