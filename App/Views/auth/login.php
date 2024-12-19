<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Tailwind CSS from CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <!-- Main container for the login form -->
    <div class="max-w-sm mx-auto bg-white shadow-lg rounded-lg p-6" role="main">
        <!-- Heading for the login form -->
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center" id="login-heading">Login</h2>

        <!-- Login form -->
        <form method="POST" action="/login" class="space-y-4" aria-labelledby="login-heading">
            <!-- Username field -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input 
                    type="text" 
                    name="username" 
                    id="username" 
                    class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500 text-gray-800" 
                    aria-required="true" 
                    placeholder="Enter your username" 
                    required
                >
            </div>
            
            <!-- Password field -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500 text-gray-800" 
                    aria-required="true" 
                    placeholder="Enter your password" 
                    required
                >
                <!-- Forgot Password Link -->
                <div class="text-right mt-2">
                    <a href="/forgot-password" class="text-blue-600 hover:underline text-sm" aria-label="Forgot your password?">
                        Forgot your password?
                    </a>
                </div>
            </div>
            
            <!-- Submit button -->
            <button 
                type="submit" 
                class="bg-blue-600 text-white w-full py-3 rounded-lg font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                aria-label="Submit login form"
            >
                Login
            </button>
        </form>
    </div>
</body>

</html>
