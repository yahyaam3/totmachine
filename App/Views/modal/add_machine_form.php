<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Machine</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full relative max-h-[90vh] overflow-y-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Add Machine</h2>
        
        <form id="add-machine-form">
            <div class="mb-4">
                <label for="model" class="block text-gray-700 font-medium mb-2">Model</label>
                <input type="text" name="model" id="model" class="border border-gray-300 rounded-lg w-full p-3" required>
            </div>

            <div class="mb-4">
                <label for="manufacturer" class="block text-gray-700 font-medium mb-2">Manufacturer</label>
                <input type="text" name="manufacturer" id="manufacturer" class="border border-gray-300 rounded-lg w-full p-3" required>
            </div>

            <div class="mb-4">
                <label for="serial_number" class="block text-gray-700 font-medium mb-2">Serial Number</label>
                <input type="text" name="serial_number" id="serial_number" class="border border-gray-300 rounded-lg w-full p-3" required>
            </div>

            <div class="mb-4">
                <label for="start_date" class="block text-gray-700 font-medium mb-2">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="border border-gray-300 rounded-lg w-full p-3" required>
            </div>

            <div class="mb-4">
                <label for="latitude" class="block text-gray-700 font-medium mb-2">Latitude</label>
                <input type="text" name="latitude" id="latitude" class="border border-gray-300 rounded-lg w-full p-3">
            </div>

            <div class="mb-4">
                <label for="longitude" class="block text-gray-700 font-medium mb-2">Longitude</label>
                <input type="text" name="longitude" id="longitude" class="border border-gray-300 rounded-lg w-full p-3">
            </div>

            <div class="mb-4">
                <label for="technician_id" class="block text-gray-700 font-medium mb-2">Technician</label>
                <select name="technician_id" id="technician_id" class="border border-gray-300 rounded-lg w-full p-3">
                    <option value="">Select Technician</option>
                    <?php foreach ($technicians as $tech): ?>
                        <option value="<?= htmlspecialchars($tech['id_user'], ENT_QUOTES, 'UTF-8'); ?>">
                            <?= htmlspecialchars($tech['username'], ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4" id="file-input-container">
                <label for="image" class="block text-gray-700 font-medium mb-2">Image (optional)</label>
                <input type="file" name="image" id="image" accept="image/*" class="border border-gray-300 rounded-lg w-full p-3">
            </div>

            <!-- Webcam section -->
            <div class="mb-4">
                <button type="button" id="webcam-btn" class="bg-blue-500 text-white p-2 rounded">Use Webcam</button>
                <div class="mt-2">
                    <video id="webcam-video" width="320" height="240" class="border" autoplay playsinline style="display:none;"></video>
                    <canvas id="webcam-canvas" width="320" height="240" style="display:none;"></canvas>
                </div>
                <div id="preview-container" class="mt-2"></div>
                <input type="hidden" name="webcam_image" id="webcam_image">
                <div class="mt-2">
                    <button type="button" id="webcam-capture-btn" class="bg-green-500 text-white p-2 rounded" style="display:none;">Capture Image</button>
                    <button type="button" id="retake-btn" class="bg-yellow-500 text-white p-2 rounded" style="display:none;">Retake Photo</button>
                </div>
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700">
                    Create
                </button>
                <button type="button" class="close-modal bg-gray-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-700">
                    Cancel
                </button>
            </div>
        </form>
    </div>

    <script>
        let stream = null;

        // Show webcam video when "Use Webcam" is clicked
        document.getElementById('webcam-btn').addEventListener('click', async () => {
            try {
                stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { 
                        width: 320,
                        height: 240
                    } 
                });
                const video = document.getElementById('webcam-video');
                video.srcObject = stream;
                video.style.display = 'block';
                document.getElementById('webcam-capture-btn').style.display = 'inline-block';
                document.getElementById('file-input-container').style.display = 'none';

                // Asegurarse de que el video se reproduce
                await video.play();
            } catch (err) {
                console.error('Error accessing webcam:', err);
                alert('Could not access webcam. Please use file upload instead.');
            }
        });

        // Capture image
        document.getElementById('webcam-capture-btn').addEventListener('click', () => {
            const video = document.getElementById('webcam-video');
            const canvas = document.getElementById('webcam-canvas');
            const ctx = canvas.getContext('2d');

            // Capture frame from video
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            // Convert to base64
            const dataURL = canvas.toDataURL('image/jpeg');
            document.getElementById('webcam_image').value = dataURL;
            
            // Show preview
            const previewContainer = document.getElementById('preview-container');
            const previewImg = document.createElement('img');
            previewImg.src = dataURL;
            previewImg.classList.add('mt-2', 'border', 'w-64');
            previewContainer.innerHTML = '';
            previewContainer.appendChild(previewImg);
            
            // Update UI
            document.getElementById('retake-btn').style.display = 'inline-block';
            document.getElementById('webcam-capture-btn').style.display = 'none';
            video.style.display = 'none';
            
            // Stop webcam stream
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
        });

        // Retake photo
        document.getElementById('retake-btn').addEventListener('click', async () => {
            try {
                document.getElementById('preview-container').innerHTML = '';
                document.getElementById('webcam_image').value = '';
                
                stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { 
                        width: 320,
                        height: 240
                    } 
                });
                const video = document.getElementById('webcam-video');
                video.srcObject = stream;
                video.style.display = 'block';
                await video.play();
                
                document.getElementById('webcam-capture-btn').style.display = 'inline-block';
                document.getElementById('retake-btn').style.display = 'none';
            } catch (err) {
                console.error('Error restarting webcam:', err);
                alert('Could not restart webcam. Please refresh the page.');
            }
        });
    </script>
</body>
</html>