const center = [49.85672, 8.63896];
const panRadius = 0.01;

const wikimediaLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
});

const map = new L.map('map');
map.setView(center, 5);
map.setMinZoom(14);
map.setMaxBounds([
    [center[0] - panRadius, center[1] - panRadius],
    [center[0] + panRadius, center[1] + panRadius]
]);

map.addLayer(wikimediaLayer);


thehood_data.forEach(function(value) {
    console.log(value);

    if (!value.lat || !value.lon) {
        return;
    }

    const pos = [value.lat, value.lon];
    L.marker(pos)
        .addTo(map)
        .bindPopup(value.title);
});
