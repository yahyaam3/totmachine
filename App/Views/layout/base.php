<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TOTMACHINE</title>
    <!-- Tailwind CSS from CDN -->
    
    <!-- Favicon -->
    <link rel="icon" href="/images/logo.png" type="image/png">
    
    <!-- Leaflet CSS (if needed) -->
    <?php if (isset($leaflet) && $leaflet): ?>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <?php endif; ?>
</head>

<body class="bg-gray-100 text-gray-900 min-h-screen">
    <!-- Navbar Section -->
    <header role="banner" aria-label="Main navigation">
        <?php include __DIR__ . "/../partials/navbar.php"; ?>
    </header>

    <!-- Main Content Section -->
    <main role="main" class="container mx-auto px-6 py-8">
        <!-- Flash Messages Section -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-500 text-white px-4 py-3 mb-4 rounded-lg shadow-lg" role="alert" aria-live="assertive">
                <?= htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        
        <?php if (isset($_GET['msg'])): ?>
            <div class="bg-green-500 text-white px-4 py-3 mb-4 rounded-lg shadow-lg" role="alert" aria-live="polite">
                <?= htmlspecialchars($_GET['msg'], ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <!-- Dynamic Content Section -->
        <section class="bg-white shadow-lg rounded-lg p-8" aria-label="Dynamic Content">
            <?php include __DIR__ . "/../" . htmlspecialchars($inner_view, ENT_QUOTES, 'UTF-8'); ?>
        </section>
    </main>

    <!-- Cookie Policy Modal -->
    <div id="cookie-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-70 z-50 hidden" role="dialog" aria-labelledby="cookie-policy-title" aria-describedby="cookie-policy-description">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full text-gray-800">
            <h1 id="cookie-policy-title" class="text-2xl font-bold mb-4">Cookie Policy</h1>
            <p id="cookie-policy-description" class="mb-4">
                We use cookies to improve your experience on our website. By using our site, you agree to our use of cookies.
            </p>
            <div class="flex justify-end space-x-4">
                <button id="accept-cookies" class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800" aria-label="Accept cookies">
                    Accept
                </button>
                <button id="reject-cookies" class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800" aria-label="Reject cookies">
                    Reject
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Container -->
    <div id="modal-container" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <!-- Modal content will be inserted here -->
    </div>

    <!-- Footer Section -->
    <footer role="contentinfo" aria-label="Website footer">
        <?php include __DIR__ . "/../partials/footer.php"; ?>
    </footer>

    <!-- Custom JavaScript -->
    <script src="/js/bundle.js"></script>
</body>
</html>
