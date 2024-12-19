<footer class="bg-gray-800 text-gray-200 mt-10 p-4" role="contentinfo">
    <div class="container mx-auto px-4 py-4">
        <!-- Grid System for Responsiveness -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
            <!-- Contact Section -->
            <div class="space-y-4 text-center md:text-left">
                <h3 class="text-lg font-semibold text-gray-100">Contact</h3>
                <ul class="text-sm space-y-2">
                    <li>
                        Email: 
                        <a href="mailto:support@totmachine.com" class="text-blue-400 hover:underline" aria-label="Email us">
                            support@totmachine.com
                        </a>
                    </li>
                    <li>
                        Phone: 
                        <a href="tel:+349725079089" class="text-blue-400 hover:underline" aria-label="Call support">
                            +34 632 50 57 97
                        </a>
                    </li>
                    <li>Address: Carrer Pelai Martínez, 1, 17600 Figueres, Girona</li>
                </ul>
            </div>

            <!-- Social Media Links -->
            <div class="text-center md:text-right">
                <h3 class="text-lg font-semibold text-gray-100 mb-2">Follow Us</h3>
                <div class="flex justify-center md:justify-end space-x-4">
                    <a href="https://www.instagram.com/yaahyasaadouni" target="_blank" rel="noopener noreferrer"
                        class="text-blue-400 hover:text-blue-300 transition duration-200">
                        Instagram
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Copyright and Policies -->
    <div class="bg-gray-900 py-2 mt-4">
        <div class="container mx-auto text-center text-xs text-gray-400">
            <p>&copy; <?= date('Y'); ?> TOTMACHINE. All rights reserved.</p>
            <a href="/cookie-policy" class="underline text-blue-400 hover:text-blue-300 transition duration-200">
                Cookie Policy
            </a>
        </div>
    </div>
</footer>
