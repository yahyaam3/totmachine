<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TOTMACHINE</title>
    <!-- Tailwind CSS desde CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Favicon -->
    <link rel="icon" href="/images/logo.png" type="image/png">
    <!-- Leaflet CSS (cargar solo si necesario) -->
    <?php if (isset($leaflet) && $leaflet): ?>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <?php endif; ?>
</head>

<body class="bg-gray-100 text-gray-900 min-h-screen">
    <!-- Navbar -->
    <?php include __DIR__ . "/../partials/navbar.php"; ?>

    <!-- Container -->
    <div class="container mx-auto px-6 py-8">
        <!-- Flash Messages -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-500 text-white px-4 py-3 mb-4 rounded-lg shadow-lg">
                <?= $_SESSION['error']; ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        <?php if (isset($_GET['msg'])): ?>
            <div class="bg-green-500 text-white px-4 py-3 mb-4 rounded-lg shadow-lg">
                <?= $_GET['msg']; ?>
            </div>
        <?php endif; ?>

        <!-- Dynamic Inner View -->
        <div class="bg-white shadow-lg rounded-lg p-8">
            <?php include __DIR__ . "/../" . $inner_view; ?>
        </div>
    </div>

    <!-- Modal de política de cookies -->
    <div id="cookie-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-70 z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full text-gray-800">
            <h1 class="text-2xl font-bold mb-4">Cookie Policy</h1>
            <p class="mb-4">
                We use cookies to improve your experience on our website. By using our site, you agree to our use of cookies.
            </p>
            <div class="flex justify-end space-x-4">
                <button id="accept-cookies" class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800">
                    Accept
                </button>
                <button id="reject-cookies" class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800">
                    Reject
                </button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include __DIR__ . "/../partials/footer.php"; ?>

    <!-- Scripts -->
    <script src="/js/bundle.js"></script>
    <!-- Leaflet JS (cargar solo si necesario) -->
    <?php if (isset($leaflet) && $leaflet): ?>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <?php endif; ?>

    <!-- Script para manejar el modal de cookies -->
    <script>
        // Verificar si las cookies ya fueron aceptadas o rechazadas
        if (!localStorage.getItem('cookiesAccepted')) {
            document.getElementById('cookie-modal').classList.remove('hidden');
        }

        // Aceptar cookies
        document.getElementById('accept-cookies').addEventListener('click', () => {
            localStorage.setItem('cookiesAccepted', 'true');
            document.getElementById('cookie-modal').classList.add('hidden');
        });

        // Rechazar cookies
        document.getElementById('reject-cookies').addEventListener('click', () => {
            localStorage.setItem('cookiesAccepted', 'false');
            document.getElementById('cookie-modal').classList.add('hidden');
        });
    </script>
</body>

</html>
