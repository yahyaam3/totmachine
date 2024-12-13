document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('map')) {
        let map = L.map('map').setView([41.3851, 2.1734], 8);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        if (window.machines) {
            window.machines.forEach(m => {
                if (m.latitude && m.longitude) {
                    let marker = L.marker([m.latitude, m.longitude]).addTo(map)
                        .bindPopup(`<strong>${m.model}</strong><br>${m.manufacturer}<br><a href="/machines/detail/${m.id_machine}" class="text-blue-500 underline">View details</a>`);
                }
            });
        }
    }
});