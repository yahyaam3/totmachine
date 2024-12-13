document.addEventListener('DOMContentLoaded', () => {
    // Handle closing modal
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('close-modal')) {
            document.getElementById('modal-container').classList.add('hidden');
            document.getElementById('modal-container').innerHTML = '';
        }
    });

    // Open "edit user" modal
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('edit-user')) {
            e.preventDefault();
            let userId = e.target.dataset.userId;
            fetch('/ajax/user-edit-form?id=' + userId)
                .then(r => r.text())
                .then(html => {
                    let mc = document.getElementById('modal-container');
                    mc.innerHTML = html;
                    mc.classList.remove('hidden');
                });
        }
    });

    // Submit "edit user" form via AJAX
    document.addEventListener('submit', (e) => {
        if (e.target.id === 'edit-user-form') {
            e.preventDefault();
            let form = e.target;
            let userId = form.dataset.userId;
            let formData = new FormData(form);
            formData.append('id', userId);
            fetch('/ajax/user-update', {
                method: 'POST',
                body: formData
            })
                .then(r => r.json())
                .then(data => {
                    if (data.result === 'ok') {
                        window.location.reload();
                    }
                });
        }
    });

    // Delete user
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('delete-user')) {
            let userId = e.target.dataset.userId;
            let formData = new FormData();
            formData.append('id', userId);
            fetch('/ajax/user-delete', {
                method: 'POST',
                body: formData
            })
                .then(r => r.json())
                .then(data => {
                    if (data.result === 'ok') {
                        window.location.reload();
                    }
                });
        }
    });

    // Open "edit machine" modal
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('edit-machine')) {
            e.preventDefault();
            let machineId = e.target.dataset.machineId;
            fetch('/ajax/machine-edit-form?id=' + machineId)
                .then(r => r.text())
                .then(html => {
                    let mc = document.getElementById('modal-container');
                    mc.innerHTML = html;
                    mc.classList.remove('hidden');
                });
        }
    });

    // Submit "edit machine" form via AJAX
    document.addEventListener('submit', (e) => {
        if (e.target.id === 'edit-machine-form') {
            e.preventDefault();
            let form = e.target;
            let machineId = form.dataset.machineId;
            let formData = new FormData(form);
            formData.append('id', machineId);
            fetch('/ajax/machine-update', {
                method: 'POST',
                body: formData
            })
                .then(r => r.json())
                .then(data => {
                    if (data.result === 'ok') {
                        window.location.reload();
                    }
                });
        }
    });

    // Delete machine
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('delete-machine')) {
            let machineId = e.target.dataset.machineId;
            let formData = new FormData();
            formData.append('id', machineId);
            fetch('/ajax/machine-delete', {
                method: 'POST',
                body: formData
            })
                .then(r => r.json())
                .then(data => {
                    if (data.result === 'ok') {
                        window.location.reload();
                    }
                });
        }
    });
});