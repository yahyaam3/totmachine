<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Management System</title>
    <!-- Tailwind CSS from CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-8">
    <main class="max-w-7xl mx-auto bg-white shadow-lg rounded-lg p-8" role="main">
        <h1 class="text-3xl font-bold text-gray-800 mb-6" aria-label="Welcome to the Maintenance Management System">
            Welcome to the Maintenance Management System
        </h1>
        <p class="text-lg text-gray-700 mb-6" aria-label="Description of the system">
            This platform allows public users to report incidents and see general system information.
        </p>

        <!-- Image Carousel Section -->
        <section id="carousel" class="relative w-full h-96 overflow-hidden rounded-lg shadow-lg" aria-labelledby="carousel-heading">
            <h2 id="carousel-heading" class="sr-only">Image Carousel</h2>
            <div id="carousel-images" class="flex transition-transform duration-700 ease-in-out w-full h-full" aria-live="polite">
                <img src="/images/ma1.jpg" class="w-full h-full object-cover flex-shrink-0" alt="Machine maintenance image 1">
                <img src="/images/ma4.jpg" class="w-full h-full object-cover flex-shrink-0" alt="Machine maintenance image 2">
                <img src="/images/ma3.jpg" class="w-full h-full object-cover flex-shrink-0" alt="Machine maintenance image 3">
            </div>

            <!-- Controls -->
            <button id="prev" class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-gray-800 text-white p-3 rounded-full focus:outline-none" aria-label="Previous slide">
                ❮
            </button>
            <button id="next" class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-gray-800 text-white p-3 rounded-full focus:outline-none" aria-label="Next slide">
                ❯
            </button>
        </section>
    </main>

    <!-- Carousel Script -->
    <script>
        const carouselImages = document.getElementById('carousel-images');
        const totalImages = carouselImages.children.length;
        let currentIndex = 0;

        // Function to move the carousel
        function updateCarousel() {
            carouselImages.style.transform = `translateX(-${currentIndex * 100}%)`;
        }

        // Next Button
        document.getElementById('next').addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % totalImages;
            updateCarousel();
        });

        // Previous Button
        document.getElementById('prev').addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + totalImages) % totalImages;
            updateCarousel();
        });

        // Auto-Slide every 5 seconds
        setInterval(() => {
            currentIndex = (currentIndex + 1) % totalImages;
            updateCarousel();
        }, 5000);
    </script>
</body>

</html>
