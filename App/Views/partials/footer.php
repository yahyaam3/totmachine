<!-- App/Views/footer.php -->


<footer class="bg-gray-800 text-gray-200 mt-10 p-4">
    <!-- Información de Contacto -->
    <div class="container mx-auto px-6 py-4">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center space-y-4 md:space-y-0">
            <!-- Contact -->
            <div class="text-center md:text-left">
                <h3 class="text-lg font-semibold text-gray-100 mb-2">Contact</h3>
                <ul class="space-y-1 text-sm">
                    <li>Email: <a href="mailto:support@totmachine.com" class="text-blue-400 hover:underline">support@totmachine.com</a></li>
                    <li>Phone: <a href="tel:+349725079089" class="text-blue-400 hover:underline">+34 972 50 79 089</a></li>
                    <li>Address: Carrer Pelai Martínez, 1, 17600 Figueres, Girona</li>
                </ul>
            </div>

            <!-- Follow Us -->
            <div class="text-center md:text-right">
                <h3 class="text-lg font-semibold text-gray-100 mb-2">Follow Us</h3>
                <ul class="flex justify-center md:justify-end space-x-4">
                <li><a href="https://www.instagram.com/yaahyasaadouni" target="_blank" class="text-blue-400 hover:underline text-sm">Instagram</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Copyright & Cookie Policy -->
    <div class="bg-gray-900 py-2">
        <div class="container mx-auto text-center text-xs text-gray-400">
            <p>&copy; <?= date('Y'); ?> TOTMACHINE. All rights reserved.</p>
            <a href="/cookie-policy" class="underline text-blue-400 hover:underline">Cookie Policy</a>
        </div>
    </div>
</footer>
