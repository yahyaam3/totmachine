<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Reset Password</h2>
        
        <form method="POST" action="/reset-password" class="space-y-4">
            <!-- Token Hidden Field -->
            <input type="hidden" name="token" value="<?= htmlspecialchars($token ?? ''); ?>">

            <!-- New Password -->
            <div>
                <label for="password" class="block text-gray-700">New Password:</label>
                <input type="password" name="password" id="password" 
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                    placeholder="Enter new password" required
                    minlength="8">
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirm" class="block text-gray-700">Confirm Password:</label>
                <input type="password" name="password_confirm" id="password_confirm" 
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                    placeholder="Confirm new password" required
                    minlength="8">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">
                Reset Password
            </button>
        </form>
    </div>
    <script>
    document.querySelector('form').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirm = document.getElementById('password_confirm').value;
        
        if (password !== confirm) {
            e.preventDefault();
            alert('Passwords do not match!');
        }
    });
    </script>
</body>
</html>
