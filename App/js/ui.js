document.addEventListener('DOMContentLoaded', () => {
    // Close modal
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('close-modal')) {
            document.getElementById('modal-container').classList.add('hidden');
            document.getElementById('modal-container').innerHTML = '';
        }
    });

    // Edit handlers
    document.addEventListener('click', (e) => {
        // Edit user
        if (e.target.classList.contains('edit-user')) {
            e.preventDefault();
            const userId = e.target.dataset.userId;
            fetch(`/ajax/user-edit-form?id=${userId}`)
                .then(response => response.text())
                .then(html => {
                    const mc = document.getElementById('modal-container');
                    mc.innerHTML = html;
                    mc.classList.remove('hidden');
                })
                .catch(error => console.error('Error:', error));
        }

        // Edit machine
        if (e.target.classList.contains('edit-machine')) {
            e.preventDefault();
            const machineId = e.target.dataset.machineId;
            fetch(`/ajax/machine-edit-form?id=${machineId}`)
                .then(response => response.text())
                .then(html => {
                    const mc = document.getElementById('modal-container');
                    mc.innerHTML = html;
                    mc.classList.remove('hidden');
                })
                .catch(error => console.error('Error:', error));
        }

        // Edit incident
        if (e.target.classList.contains('edit-incident')) {
            e.preventDefault();
            const incidentId = e.target.dataset.incidentId;
            fetch(`/ajax/incident-edit-form?id=${incidentId}`)
                .then(response => response.text())
                .then(html => {
                    const mc = document.getElementById('modal-container');
                    mc.innerHTML = html;
                    mc.classList.remove('hidden');
                })
                .catch(error => console.error('Error:', error));
        }

        // Edit maintenance
        if (e.target.classList.contains('edit-maintenance')) {
            e.preventDefault();
            const maintenanceId = e.target.dataset.maintenanceId;
            fetch(`/ajax/maintenance-edit-form?id=${maintenanceId}`)
                .then(response => response.text())
                .then(html => {
                    const mc = document.getElementById('modal-container');
                    mc.innerHTML = html;
                    mc.classList.remove('hidden');
                })
                .catch(error => console.error('Error:', error));
        }
    });

    // Add handlers
    document.addEventListener('click', (e) => {
        // Add machine modal
        if (e.target.classList.contains('add-machine')) {
            e.preventDefault();
            console.log('Add machine button clicked'); // Para debugging
            fetch('/ajax/machine-add-form')
                .then(response => response.text())
                .then(html => {
                    const mc = document.getElementById('modal-container');
                    mc.innerHTML = html;
                    mc.classList.remove('hidden');
                    
                    // Initialize webcam after modal is loaded
                    initializeWebcam();
                })
                .catch(error => console.error('Error:', error));
        }

        // Add user modal
        if (e.target.classList.contains('add-user')) {
            e.preventDefault();
            fetch('/ajax/user-add-form')
                .then(response => response.text())
                .then(html => {
                    const mc = document.getElementById('modal-container');
                    mc.innerHTML = html;
                    mc.classList.remove('hidden');
                })
                .catch(error => console.error('Error:', error));
        }

        // Add maintenance modal
        if (e.target.classList.contains('add-maintenance')) {
            e.preventDefault();
            fetch('/ajax/maintenance-add-form')
                .then(response => response.text())
                .then(html => {
                    const mc = document.getElementById('modal-container');
                    mc.innerHTML = html;
                    mc.classList.remove('hidden');
                })
                .catch(error => console.error('Error:', error));
        }
    });

    // Form submissions
    document.addEventListener('submit', (e) => {
        // User update
        if (e.target.id === 'edit-user-form') {
            e.preventDefault();
            const form = e.target;
            const userId = form.dataset.userId;
            const formData = new FormData(form);
            formData.append('id', userId);

            fetch('/ajax/user-update', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.result === 'ok') {
                    const row = document.querySelector(`tr[data-user-id="${userId}"]`);
                    if (row) {
                        row.querySelector('td:nth-child(1)').textContent = `${formData.get('name')} ${formData.get('surname')}`;
                        row.querySelector('td:nth-child(3)').textContent = formData.get('email');
                    }
                    const modal = document.getElementById('modal-container');
                    modal.classList.add('hidden');
                    modal.innerHTML = '';
                    // Mensaje único
                    alert('User updated successfully');
                } else {
                    alert('Error updating user: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Machine update
        if (e.target.id === 'edit-machine-form') {
            e.preventDefault();
            const form = e.target;
            const machineId = form.dataset.machineId;
            const formData = new FormData(form);
            formData.append('id', machineId);

            fetch('/ajax/machine-update', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.result === 'ok') {
                    const row = document.querySelector(`tr[data-machine-id="${machineId}"]`);
                    if (row) {
                        row.querySelector('td:nth-child(1)').textContent = formData.get('model');
                        row.querySelector('td:nth-child(2)').textContent = formData.get('manufacturer');
                        row.querySelector('td:nth-child(3)').textContent = formData.get('serial_number');
                    }
                    const modal = document.getElementById('modal-container');
                    modal.classList.add('hidden');
                    modal.innerHTML = '';
                    // Mostrar mensaje de éxito una sola vez
                    alert('Machine updated successfully');
                } else {
                    alert('Error updating machine: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Incident update
        if (e.target.id === 'edit-incident-form') {
            e.preventDefault();
            const form = e.target;
            const incidentId = form.dataset.incidentId;
            const formData = new FormData(form);
            formData.append('id', incidentId);

            fetch('/ajax/incident-update', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.result === 'ok') {
                    const row = document.querySelector(`tr[data-incident-id="${incidentId}"]`);
                    if (row) {
                        row.querySelector('td:nth-child(1)').textContent = formData.get('description');
                        row.querySelector('td:nth-child(2)').textContent = formData.get('priority');
                        row.querySelector('td:nth-child(3)').textContent = formData.get('status');
                    }
                    const modal = document.getElementById('modal-container');
                    modal.classList.add('hidden');
                    modal.innerHTML = '';
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Maintenance update
        if (e.target.id === 'edit-maintenance-form') {
            e.preventDefault();
            const form = e.target;
            const maintenanceId = form.dataset.maintenanceId;
            const formData = new FormData(form);
            formData.append('id', maintenanceId);

            fetch('/ajax/maintenance-update', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.result === 'ok') {
                    const row = document.querySelector(`tr[data-maintenance-id="${maintenanceId}"]`);
                    if (row) {
                        row.querySelector('td:nth-child(1)').textContent = formData.get('type');
                        row.querySelector('td:nth-child(2)').textContent = formData.get('description');
                        row.querySelector('td:nth-child(3)').textContent = formData.get('date');
                        row.querySelector('td:nth-child(4)').textContent = formData.get('time_spent') + 'h';
                    }
                    const modal = document.getElementById('modal-container');
                    modal.classList.add('hidden');
                    modal.innerHTML = '';
                    alert('Maintenance updated successfully');
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Add machine form submission
        if (e.target.id === 'add-machine-form') {
            e.preventDefault();
            console.log('Form submitted'); // Para debugging
            const form = e.target;
            const formData = new FormData(form);

            // Deshabilitar el botón de submit para evitar múltiples envíos
            const submitButton = form.querySelector('button[type="submit"]');
            submitButton.disabled = true;

            fetch('/ajax/machine-store', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.result === 'ok') {
                    // Add new row to table
                    const tbody = document.querySelector('table tbody');
                    const newRow = document.createElement('tr');
                    newRow.setAttribute('data-machine-id', data.machine.id_machine);
                    newRow.innerHTML = `
                        <td class="p-4">${formData.get('model')}</td>
                        <td class="p-4">${formData.get('manufacturer')}</td>
                        <td class="p-4">${formData.get('serial_number')}</td>
                        <td class="p-4">
                            <a href="/machines/detail/${data.machine.id_machine}" class="text-blue-600 hover:underline">Detail</a>
                            <button class="edit-machine text-yellow-600 hover:underline" data-machine-id="${data.machine.id_machine}">Edit</button>
                        </td>
                    `;
                    tbody.insertBefore(newRow, tbody.firstChild);

                    // Close modal
                    const modal = document.getElementById('modal-container');
                    modal.classList.add('hidden');
                    modal.innerHTML = '';

                    // Show success message
                    alert('Machine added successfully');

                    // Limpiar el formulario
                    form.reset();
                } else {
                    alert('Error adding machine: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error adding machine');
            })
            .finally(() => {
                // Re-habilitar el botón de submit
                submitButton.disabled = false;
            });
        }

        // Add maintenance form submission
        if (e.target.id === 'add-maintenance-form') {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);

            fetch('/ajax/maintenance-store', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.result === 'ok') {
                    const tbody = document.querySelector('table tbody');
                    const newRow = document.createElement('tr');
                    newRow.setAttribute('data-maintenance-id', data.maintenance.id_maintenance);
                    newRow.innerHTML = `
                        <td class="p-4">${formData.get('type')}</td>
                        <td class="p-4">${formData.get('description')}</td>
                        <td class="p-4">${formData.get('date')}</td>
                        <td class="p-4">${formData.get('time_spent')}h</td>
                        <td class="p-4"></td>
                        <td class="p-4">
                            <button class="edit-maintenance text-yellow-600 hover:underline" data-maintenance-id="${data.maintenance.id_maintenance}">Edit</button>
                            <button class="delete-maintenance text-red-600 hover:underline" data-maintenance-id="${data.maintenance.id_maintenance}">Delete</button>
                        </td>
                    `;
                    tbody.insertBefore(newRow, tbody.firstChild);

                    const modal = document.getElementById('modal-container');
                    modal.classList.add('hidden');
                    modal.innerHTML = '';
                    alert('Maintenance added successfully');
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Add user form submission
        if (e.target.id === 'add-user-form') {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);

            fetch('/ajax/user-store', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.result === 'ok') {
                    const tbody = document.querySelector('table tbody');
                    const newRow = document.createElement('tr');
                    newRow.setAttribute('data-user-id', data.user.id_user);
                    newRow.innerHTML = `
                        <td class="p-4">${formData.get('name')} ${formData.get('surname')}</td>
                        <td class="p-4">${formData.get('username')}</td>
                        <td class="p-4">${formData.get('email')}</td>
                        <td class="p-4">${formData.get('role')}</td>
                        <td class="p-4">
                            <button class="edit-user text-yellow-600 hover:underline" data-user-id="${data.user.id_user}">Edit</button>
                            <button class="delete-user text-red-600 hover:underline" data-user-id="${data.user.id_user}">Delete</button>
                        </td>
                    `;
                    tbody.insertBefore(newRow, tbody.firstChild);

                    const modal = document.getElementById('modal-container');
                    modal.classList.add('hidden');
                    modal.innerHTML = '';
                    alert('User added successfully');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });

    // Delete handlers
    document.addEventListener('click', (e) => {
        // Delete user
        if (e.target.classList.contains('delete-user')) {
            if (confirm('Are you sure you want to delete this user?')) {
                const userId = e.target.dataset.userId;
                const formData = new FormData();
                formData.append('id', userId);

                fetch('/ajax/user-delete', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.result === 'ok') {
                        const row = document.querySelector(`tr[data-user-id="${userId}"]`);
                        if (row) row.remove();
                        const modal = document.getElementById('modal-container');
                        modal.classList.add('hidden');
                        modal.innerHTML = '';
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }

        // Delete machine
        if (e.target.classList.contains('delete-machine')) {
            if (confirm('Are you sure you want to delete this machine?')) {
                const machineId = e.target.dataset.machineId;
                const formData = new FormData();
                formData.append('id', machineId);

                fetch('/ajax/machine-delete', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.result === 'ok') {
                        const row = document.querySelector(`tr[data-machine-id="${machineId}"]`);
                        if (row) row.remove();
                        const modal = document.getElementById('modal-container');
                        modal.classList.add('hidden');
                        modal.innerHTML = '';
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }

        // Delete incident
        if (e.target.classList.contains('delete-incident')) {
            if (confirm('Are you sure you want to delete this incident?')) {
                const incidentId = e.target.dataset.incidentId;
                const formData = new FormData();
                formData.append('id', incidentId);

                fetch('/ajax/incident-delete', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.result === 'ok') {
                        const row = document.querySelector(`tr[data-incident-id="${incidentId}"]`);
                        if (row) row.remove();
                        const modal = document.getElementById('modal-container');
                        modal.classList.add('hidden');
                        modal.innerHTML = '';
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }

        // Delete maintenance
        if (e.target.classList.contains('delete-maintenance')) {
            if (confirm('Are you sure you want to delete this maintenance record?')) {
                const maintenanceId = e.target.dataset.maintenanceId;
                const formData = new FormData();
                formData.append('id', maintenanceId);

                fetch('/ajax/maintenance-delete', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.result === 'ok') {
                        const row = document.querySelector(`tr[data-maintenance-id="${maintenanceId}"]`);
                        if (row) row.remove();
                        const modal = document.getElementById('modal-container');
                        modal.classList.add('hidden');
                        modal.innerHTML = '';
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }
    });
});

// Add this function to handle webcam initialization
function initializeWebcam() {
    let stream = null;
    const webcamBtn = document.getElementById('webcam-btn');
    const video = document.getElementById('webcam-video');
    const canvas = document.getElementById('webcam-canvas');
    const captureBtn = document.getElementById('webcam-capture-btn');
    const retakeBtn = document.getElementById('retake-btn');
    const previewContainer = document.getElementById('preview-container');
    const webcamInput = document.getElementById('webcam_image');
    const fileInputContainer = document.getElementById('file-input-container');

    if (webcamBtn) {
        webcamBtn.addEventListener('click', async () => {
            try {
                stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { 
                        width: 320, 
                        height: 240 
                    } 
                });
                video.srcObject = stream;
                video.style.display = 'block';
                captureBtn.style.display = 'inline-block';
                fileInputContainer.style.display = 'none';
                await video.play();
            } catch (err) {
                console.error('Error accessing webcam:', err);
                alert('Could not access webcam. Please use file upload instead.');
            }
        });
    }

    if (captureBtn) {
        captureBtn.addEventListener('click', () => {
            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            const dataURL = canvas.toDataURL('image/jpeg', 0.8);
            webcamInput.value = dataURL;

            const previewImg = document.createElement('img');
            previewImg.src = dataURL;
            previewImg.classList.add('mt-2', 'border', 'w-64');
            previewContainer.innerHTML = '';
            previewContainer.appendChild(previewImg);

            video.style.display = 'none';
            captureBtn.style.display = 'none';
            retakeBtn.style.display = 'inline-block';

            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
        });
    }

    if (retakeBtn) {
        retakeBtn.addEventListener('click', async () => {
            try {
                previewContainer.innerHTML = '';
                webcamInput.value = '';

                stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { 
                        width: 320, 
                        height: 240 
                    } 
                });
                video.srcObject = stream;
                video.style.display = 'block';
                await video.play();

                captureBtn.style.display = 'inline-block';
                retakeBtn.style.display = 'none';
            } catch (err) {
                console.error('Error restarting webcam:', err);
                alert('Could not restart webcam. Please refresh the page.');
            }
        });
    }
}