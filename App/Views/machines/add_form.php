<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Machine</title>
    <!-- Tailwind CSS desde CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900 min-h-screen">
    <div class="container mx-auto px-6 py-8">
        <div class="bg-white shadow-lg rounded-lg p-8 max-w-lg mx-auto">
            <h2 class="text-2xl font-semibold mb-6 text-gray-800">Add Machine</h2>
            <form method="POST" action="/machines/store" enctype="multipart/form-data">
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Model</label>
                    <input type="text" name="model" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Manufacturer</label>
                    <input type="text" name="manufacturer" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Serial Number</label>
                    <input type="text" name="serial_number" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Start Date</label>
                    <input type="date" name="start_date" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Latitude</label>
                    <input type="text" name="latitude" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Longitude</label>
                    <input type="text" name="longitude" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Image (optional)</label>
                    <input type="file" name="image" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Webcam capture section -->
                <div class="mb-6">
                    <button type="button" id="webcam-btn" class="bg-blue-500 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Use Webcam
                    </button>
                    <div class="mt-4">
                        <video id="webcam-video" width="320" height="240" class="border rounded-lg" autoplay playsinline style="display:none;"></video>
                        <canvas id="webcam-canvas" width="320" height="240" style="display:none;"></canvas>
                        <input type="hidden" name="webcam_image" id="webcam-input">
                    </div>
                    <button type="button" id="webcam-capture-btn" class="bg-green-500 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-600 mt-4" style="display:none;">
                        Capture Image
                    </button>
                </div>

                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Create
                </button>
            </form>
        </div>
    </div>

    <script>
        // Show webcam video when "Use Webcam" is clicked
        document.getElementById('webcam-btn').addEventListener('click', async () => {
            let stream = await navigator.mediaDevices.getUserMedia({ video: true });
            const video = document.getElementById('webcam-video');
            const captureBtn = document.getElementById('webcam-capture-btn');
            video.srcObject = stream;
            video.style.display = 'block';
            captureBtn.style.display = 'inline-block';
        });

        // Capture image and put into hidden input as base64
        document.getElementById('webcam-capture-btn').addEventListener('click', () => {
            const video = document.getElementById('webcam-video');
            const canvas = document.getElementById('webcam-canvas');
            const input = document.getElementById('webcam-input');
            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            const dataURL = canvas.toDataURL('image/jpeg');
            input.value = dataURL;
            // Stop the webcam stream
            video.srcObject.getTracks().forEach(t => t.stop());
            video.style.display = 'none';
            document.getElementById('webcam-capture-btn').style.display = 'none';
        });
    </script>
</body>

</html>
