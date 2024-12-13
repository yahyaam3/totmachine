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

    <!-- Footer -->
    <?php include __DIR__ . "/../partials/footer.php"; ?>

    <!-- Modal Container -->
    <div id="modal-container" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
        <!-- Modal content dynamically loaded -->
    </div>

    <!-- Scripts -->
    <script src="/js/bundle.js"></script>
    <!-- Leaflet JS (cargar solo si necesario) -->
    <?php if (isset($leaflet) && $leaflet): ?>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <?php endif; ?>
</body>

</html>
