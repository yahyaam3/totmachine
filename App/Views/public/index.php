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
                <img src="/images/ma4.jpg" class="w-full h-full object-cover flex-shrink-0" alt="Image 2">
                <img src="/images/ma3.jpg" class="w-full h-full object-cover flex-shrink-0" alt="Image 3">
            </div>
            <!-- Controles -->
            <button id="prev" class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-gray-800 text-white p-3 rounded-full focus:outline-none">❮</button>
            <button id="next" class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-gray-800 text-white p-3 rounded-full focus:outline-none">❯</button>
        </div>
    </div>

    <!-- Script para manejar el carrusel -->
    <script>
        const carouselImages = document.getElementById('carousel-images');
        const totalImages = carouselImages.children.length;
        let currentIndex = 0;

        // Función para mover el carrusel
        function updateCarousel() {
            carouselImages.style.transform = `translateX(-${currentIndex * 100}%)`;
        }

        // Botón "Siguiente"
        document.getElementById('next').addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % totalImages;
            updateCarousel();
        });

        // Botón "Anterior"
        document.getElementById('prev').addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + totalImages) % totalImages;
            updateCarousel();
        });

        // Cambio automático cada 5 segundos
        setInterval(() => {
            currentIndex = (currentIndex + 1) % totalImages;
            updateCarousel();
        }, 5000);
    </script>
</body>

</html>
