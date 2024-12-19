<div class="max-w-sm mx-auto">
    <h2 class="text-xl mb-4">Add Machine</h2>
    <form method="POST" action="/machines/store" enctype="multipart/form-data">
        <div class="mb-2">
            <label>Model</label>
            <input type="text" name="model" class="border w-full p-2" required>
        </div>
        <div class="mb-2">
            <label>Manufacturer</label>
            <input type="text" name="manufacturer" class="border w-full p-2" required>
        </div>
        <div class="mb-2">
            <label>Serial Number</label>
            <input type="text" name="serial_number" class="border w-full p-2" required>
        </div>
        <div class="mb-2">
            <label>Start Date</label>
            <input type="date" name="start_date" class="border w-full p-2" required>
        </div>
        <div class="mb-2">
            <label>Latitude</label>
            <input type="text" name="latitude" class="border w-full p-2">
        </div>
        <div class="mb-2">
            <label>Longitude</label>
            <input type="text" name="longitude" class="border w-full p-2">
        </div>
        <div class="mb-2" id="file-input-container">
            <label>Image (optional)</label>
            <input type="file" name="image" accept="image/*" class="border w-full p-2">
        </div>

        <!-- Updated webcam capture section -->
        <div class="mb-4">
            <button type="button" id="webcam-btn" class="bg-blue-500 text-white p-2 rounded">Use Webcam</button>
            <div class="mt-2">
                <video id="webcam-video" width="320" height="240" class="border" autoplay playsinline
                    style="display:none;"></video>
                <canvas id="webcam-canvas" width="320" height="240" style="display:none;"></canvas>
                <div id="preview-container" class="mt-2"></div>
                <input type="hidden" name="webcam_image" id="webcam_image">
            </div>
            <div class="mt-2">
                <button type="button" id="webcam-capture-btn" class="bg-green-500 text-white p-2 rounded"
                    style="display:none;">Capture Image</button>
                <button type="button" id="retake-btn" class="bg-yellow-500 text-white p-2 rounded"
                    style="display:none;">Retake Photo</button>
            </div>
        </div>

        <button type="submit" class="bg-blue-500 text-white p-2 rounded">Create</button>
    </form>
</div>

<script>
    let stream = null;

    // Show webcam video when "Use Webcam" is clicked
    document.getElementById('webcam-btn').addEventListener('click', async () => {
        try {
            stream = await navigator.mediaDevices.getUserMedia({ video: true });
            const video = document.getElementById('webcam-video');
            const captureBtn = document.getElementById('webcam-capture-btn');
            video.srcObject = stream;
            video.style.display = 'block';
            captureBtn.style.display = 'inline-block';
            document.getElementById('file-input-container').style.display = 'none';
        } catch (err) {
            console.error('Error accessing webcam:', err);
            alert('Could not access webcam. Please use file upload instead.');
        }
    });

    // Capture image and show preview
    document.getElementById('webcam-capture-btn').addEventListener('click', () => {
        const video = document.getElementById('webcam-video');
        const canvas = document.getElementById('webcam-canvas');
        const webcamInput = document.getElementById('webcam_image');
        const previewContainer = document.getElementById('preview-container');
        const ctx = canvas.getContext('2d');

        // Capture frame to canvas
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        const dataURL = canvas.toDataURL('image/jpeg');
        
        // Set captured image data
        webcamInput.value = dataURL;
        
        // Create and show preview
        const previewImg = document.createElement('img');
        previewImg.src = dataURL;
        previewImg.classList.add('mt-2', 'border', 'w-64');
        previewContainer.innerHTML = '';
        previewContainer.appendChild(previewImg);
        
        // Show retake button, hide video and capture button
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
            // Clear preview and hidden input
            document.getElementById('preview-container').innerHTML = '';
            document.getElementById('webcam_image').value = '';
            
            // Restart webcam
            stream = await navigator.mediaDevices.getUserMedia({ video: true });
            const video = document.getElementById('webcam-video');
            video.srcObject = stream;
            video.style.display = 'block';
            
            // Show/hide appropriate buttons
            document.getElementById('webcam-capture-btn').style.display = 'inline-block';
            document.getElementById('retake-btn').style.display = 'none';
        } catch (err) {
            console.error('Error restarting webcam:', err);
            alert('Could not restart webcam. Please refresh the page.');
        }
    });
</script>