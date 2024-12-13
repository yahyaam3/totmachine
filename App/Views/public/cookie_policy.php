<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Management System</title>
    <!-- Tailwind CSS desde CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-8">
    <div class="max-w-7xl mx-auto bg-white shadow-lg rounded-lg p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Welcome to the Maintenance Management System</h1>
        <p class="text-lg text-gray-700 mb-6">
            This platform allows public users to report incidents and see general system information.
        </p>

        <!-- Carrusel de imágenes -->
        <div id="carousel" class="relative w-full h-96 overflow-hidden rounded-lg shadow-lg">
            <!-- Contenedor de imágenes -->
            <div id="carousel-images" class="flex transition-transform duration-700 ease-in-out w-full h-full">
                <img src="/images/ma1.jpg" class="w-full h-full object-cover flex-shrink-0" alt="Image 1">
                <img src="/images/ma2.jpg" class="w-full h-full object-cover flex-shrink-0" alt="Image 2">
                <img src="/images/ma3.jpg" class="w-full h-full object-cover flex-shrink-0" alt="Image 3">
            </div>
            <!-- Controles -->
            <button id="prev" class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-gray-800 text-white p-3 rounded-full focus:outline-none">❮</button>
            <button id="next" class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-gray-800 text-white p-3 rounded-full focus:outline-none">❯</button>
        </div>
    </div>

    <!-- Modal de política de cookies -->
    <div id="cookie-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-lg text-gray-800">
            <h1 class="text-2xl font-bold mb-4">Cookie Policy</h1>
            <p class="mb-4">
                We use cookies to improve your experience on our website. By using our site, you agree to our use of cookies.
            </p>
            <p class="mb-4">
                Cookies are small text files stored on your device that help us enhance site functionality and remember your preferences.
            </p>
            <p class="mb-4">
                <strong>Types of Cookies We Use:</strong>
                <ul class="list-disc pl-6">
                    <li>Essential Cookies: Required for site functionality.</li>
                    <li>Performance Cookies: Help us improve the site by tracking usage.</li>
                    <li>Functional Cookies: Remember your settings and preferences.</li>
                </ul>
            </p>
            <p class="mb-4">
                You can control cookies through your browser settings. Disabling cookies may affect site performance.
            </p>
            <p class="mb-4">
                <strong>Third-Party Cookies:</strong> Some cookies may be set by third parties for analytics and advertising purposes.
            </p>
            <p class="mb-4">
                For questions about our Cookie Policy, contact us at [your contact information].
            </p>
            <div class="flex justify-end space-x-4">
                <button id="accept-cookies" class="bg-green-500 text-white px-4 py-2 rounded-lg">Accept</button>
                <button id="reject-cookies" class="bg-red-500 text-white px-4 py-2 rounded-lg">Reject</button>
            </div>
        </div>
    </div>

    <!-- Script para manejar el modal de cookies -->
    <script>
        // Comprobar si ya se aceptaron/rechazaron las cookies
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

    <!-- Script para manejar el carrusel -->
    <script>
        const carouselImages = document.getElementById('carousel-images');
        const totalImages = carouselImages.children.length;
        let currentIndex = 0;

        function updateCarousel() {
            carouselImages.style.transform = `translateX(-${currentIndex * 100}%)`;
        }

        document.getElementById('next').addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % totalImages;
            updateCarousel();
        });

        document.getElementById('prev').addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + totalImages) % totalImages;
            updateCarousel();
        });

        setInterval(() => {
            currentIndex = (currentIndex + 1) % totalImages;
            updateCarousel();
        }, 5000);
    </script>
</body>

</html>
