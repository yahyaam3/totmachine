<footer class="bg-gray-800 text-gray-200 mt-10 p-4" role="contentinfo">
    <!-- Contact Information Section -->
    <div class="container mx-auto px-6 py-4">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center space-y-4 md:space-y-0">
            <!-- Contact Details -->
            <div class="text-center md:text-left">
                <h3 class="text-lg font-semibold text-gray-100 mb-2">Contact</h3>
                <ul class="space-y-1 text-sm" aria-label="Contact Information">
                    <li>
                        Email: 
                        <a href="mailto:support@totmachine.com" class="text-blue-400 hover:underline" aria-label="Email support at TOTMACHINE">
                            support@totmachine.com
                        </a>
                    </li>
                    <li>
                        Phone: 
                        <a href="tel:+349725079089" class="text-blue-400 hover:underline" aria-label="Call TOTMACHINE support at +34 972 50 79 089">
                            +34 632 50 57 97
                        </a>
                    </li>
                    <li>
                        Address: Carrer Pelai Martínez, 1, 17600 Figueres, Girona
                    </li>
                </ul>
            </div>

            <!-- Social Media Links -->
            <div class="text-center md:text-right">
                <h3 class="text-lg font-semibold text-gray-100 mb-2">Follow Us</h3>
                <ul class="flex justify-center md:justify-end space-x-4" aria-label="Social Media Links">
                    <li>
                        <a href="https://www.instagram.com/yaahyasaadouni" target="_blank" rel="noopener noreferrer" class="text-blue-400 hover:underline text-sm" aria-label="Visit our Instagram profile">
                            Instagram
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Copyright and Cookie Policy Section -->
    <div class="bg-gray-900 py-2">
        <div class="container mx-auto text-center text-xs text-gray-400">
            <p>&copy; <?= date('Y'); ?> TOTMACHINE. All rights reserved.</p>
            <a href="/cookie-policy" class="underline text-blue-400 hover:underline" aria-label="Read our Cookie Policy">
                Cookie Policy
            </a>
        </div>
    </div>
</footer>
