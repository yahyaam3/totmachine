// Example code for capturing images from webcam.
// If not needed, you can remove or adjust.
document.addEventListener('DOMContentLoaded', () => {
    const webcamBtn = document.getElementById('webcam-btn');
    const webcamVideo = document.getElementById('webcam-video');
    const webcamCaptureBtn = document.getElementById('webcam-capture-btn');
    const webcamCanvas = document.getElementById('webcam-canvas');
    const webcamInput = document.getElementById('webcam-input');

    if (webcamBtn && webcamVideo && webcamCaptureBtn && webcamCanvas && webcamInput) {
        let stream = null;
        webcamBtn.addEventListener('click', async () => {
            stream = await navigator.mediaDevices.getUserMedia({ video: true });
            webcamVideo.srcObject = stream;
            webcamVideo.play();
        });

        webcamCaptureBtn.addEventListener('click', () => {
            let ctx = webcamCanvas.getContext('2d');
            ctx.drawImage(webcamVideo, 0, 0, webcamCanvas.width, webcamCanvas.height);
            let dataURL = webcamCanvas.toDataURL('image/jpeg');
            webcamInput.value = dataURL;
            stream.getTracks().forEach(t => t.stop());
        });
    }
});