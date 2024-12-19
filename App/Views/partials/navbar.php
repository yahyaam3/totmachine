<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project3</title>
    <!-- Tailwind CSS from CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 text-gray-900">
    <?php
    $user_role = $_SESSION['user_role'] ?? '';
    $username = $_SESSION['username'] ?? '';
    ?>
    <!-- Main Navigation -->
    <nav class="bg-gray-800" role="navigation" aria-label="Main navigation">
        <div class="container mx-auto py-3 px-4">
            <!-- Logo and Title -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <img src="/images/logo.png" alt="TOTMACHINE Logo" class="h-14 mr-3">
                    <span class="text-xl font-bold tracking-wide">
                        <span class="text-white">TOT</span>
                        <span class="text-blue-500">MACHINE</span>
                    </span>
                </div>
                <!-- User Actions -->
                <div class="flex items-center space-x-4">
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <a href="/login" 
                           class="bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-md text-sm font-medium flex items-center transition duration-200 shadow-md" 
                           aria-label="Login">
                            <i class="fas fa-sign-in-alt mr-2"></i> Login
                        </a>
                    <?php else: ?>
                        <span class="text-gray-300" aria-label="Greeting">Hello, <?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?></span>
                        
                        <!-- Profile Button -->
                        <a href="/users/profile" 
                           class="bg-blue-700 text-white hover:bg-blue-800 px-4 py-2 rounded-md text-sm font-medium flex items-center transition duration-200 shadow-md" 
                           aria-label="View your profile">
                            <i class="fas fa-user mr-2"></i> Profile
                        </a>

                        <!-- Logout Button -->
                        <a href="/logout" 
                           class="bg-red-700 text-white hover:bg-red-800 px-4 py-2 rounded-md text-sm font-medium flex items-center transition duration-200 shadow-md" 
                           aria-label="Logout">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="mt-4 flex justify-center space-x-4" role="menu" aria-label="Menu">
                <a href="/" 
                   class="bg-gray-700 text-gray-300 hover:bg-gray-600 hover:text-white px-4 py-2 rounded-md text-sm font-medium flex items-center transition duration-200" 
                   aria-label="Go to Home">
                    <i class="fas fa-home mr-2"></i> Home
                </a>
                <?php if (in_array($user_role, ['TECHNICAL', 'SUPERVISOR', 'ADMINISTRATOR'])): ?>
                    <a href="/machines/list" 
                       class="bg-gray-700 text-gray-300 hover:bg-gray-600 hover:text-white px-4 py-2 rounded-md text-sm font-medium flex items-center transition duration-200" 
                       aria-label="View machines list">
                        <i class="fas fa-cogs mr-2"></i> Machines
                    </a>
                    <a href="/incidents/list" 
                       class="bg-gray-700 text-gray-300 hover:bg-gray-600 hover:text-white px-4 py-2 rounded-md text-sm font-medium flex items-center transition duration-200" 
                       aria-label="View incidents list">
                        <i class="fas fa-exclamation-circle mr-2"></i> Incidents
                    </a>
                    <a href="/maintenance/list" 
                       class="bg-gray-700 text-gray-300 hover:bg-gray-600 hover:text-white px-4 py-2 rounded-md text-sm font-medium flex items-center transition duration-200" 
                       aria-label="View maintenance list">
                        <i class="fas fa-tools mr-2"></i> Maintenance
                    </a>
                <?php endif; ?>
                <?php if (in_array($user_role, ['SUPERVISOR', 'ADMINISTRATOR'])): ?>
                    <a href="/machines/import" 
                       class="bg-gray-700 text-gray-300 hover:bg-gray-600 hover:text-white px-4 py-2 rounded-md text-sm font-medium flex items-center transition duration-200" 
                       aria-label="Import machines from CSV">
                        <i class="fas fa-file-import mr-2"></i> Import CSV
                    </a>
                <?php endif; ?>
                <?php if ($user_role == 'ADMINISTRATOR'): ?>
                    <a href="/users/list" 
                       class="bg-gray-700 text-gray-300 hover:bg-gray-600 hover:text-white px-4 py-2 rounded-md text-sm font-medium flex items-center transition duration-200" 
                       aria-label="Manage users">
                        <i class="fas fa-users mr-2"></i> Users
                    </a>
                <?php endif; ?>
                <?php if (empty($user_role)): ?>
                    <a href="/public/register-incident" 
                       class="bg-gray-700 text-gray-300 hover:bg-gray-600 hover:text-white px-4 py-2 rounded-md text-sm font-medium flex items-center transition duration-200" 
                       aria-label="Publicly report an incident">
                        <i class="fas fa-exclamation-triangle mr-2"></i> Report Incident (Public)
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</body>

</html>