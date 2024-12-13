<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project3</title>
    <!-- Tailwind CSS desde CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900">
    <?php
    $user_role = $_SESSION['user_role'] ?? '';
    $username = $_SESSION['username'] ?? '';
    ?>
    <nav class="bg-gray-800">
        <div class="container mx-auto py-2 px-4">
            <!-- Logo y título -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                <img src="/images/logo.png" alt="Logo" class="h-14 mr-3">
                    <span class="text-xl font-bold tracking-wide">
                        <span class="text-white">TOT</span>
                        <span class="text-blue-500 ">MACHINE</span>
                    </span>
                </div>
                <!-- User Action -->
                <div>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <a href="/login" class="bg-blue-500 text-white hover:bg-blue-600 px-4 py-2 rounded-md text-sm font-medium">Login</a>
                    <?php else: ?>
                        <span class="text-gray-300 mr-4">Hello, <?= $username; ?></span>
                        <a href="/users/profile" class="bg-blue-500 text-white hover:bg-blue-600 px-4 py-2 rounded-md text-sm font-medium">Profile</a>
                        <a href="/logout" class="bg-red-500 text-white hover:bg-red-600 px-4 py-2 rounded-md text-sm font-medium">Logout</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Links -->
            <div class="mt-6 flex justify-center space-x-4">
                <a href="/" class="bg-gray-700 text-gray-300 hover:bg-gray-600 hover:text-white px-4 py-2 rounded-md text-sm font-medium flex items-center justify-center">Home</a>
                <?php if ($user_role == 'TECHNICAL' || $user_role == 'SUPERVISOR' || $user_role == 'ADMINISTRATOR'): ?>
                    <a href="/machines/list" class="bg-gray-700 text-gray-300 hover:bg-gray-600 hover:text-white px-4 py-2 rounded-md text-sm font-medium flex items-center justify-center">Machines</a>
                    <a href="/incidents/list" class="bg-gray-700 text-gray-300 hover:bg-gray-600 hover:text-white px-4 py-2 rounded-md text-sm font-medium flex items-center justify-center">Incidents</a>
                    <a href="/maintenance/list" class="bg-gray-700 text-gray-300 hover:bg-gray-600 hover:text-white px-4 py-2 rounded-md text-sm font-medium flex items-center justify-center">Maintenance</a>
                <?php endif; ?>
                <?php if ($user_role == 'SUPERVISOR' || $user_role == 'ADMINISTRATOR'): ?>
                    <a href="/machines/import" class="bg-gray-700 text-gray-300 hover:bg-gray-600 hover:text-white px-4 py-2 rounded-md text-sm font-medium flex items-center justify-center">Import CSV</a>
                <?php endif; ?>
                <?php if ($user_role == 'ADMINISTRATOR'): ?>
                    <a href="/users/list" class="bg-gray-700 text-gray-300 hover:bg-gray-600 hover:text-white px-4 py-2 rounded-md text-sm font-medium flex items-center justify-center">Users</a>
                <?php endif; ?>
                <?php if (empty($user_role)): ?>
                    <a href="/public/register-incident" class="bg-gray-700 text-gray-300 hover:bg-gray-600 hover:text-white px-4 py-2 rounded-md text-sm font-medium flex items-center justify-center">Report Incident (Public)</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</body>

</html>
