let currentPosition = null;
let map = L.map('map', {
    markerZoomAnimation: true,
    zoom: 15,
});
let markersCurrentPosition = L.layerGroup([]);
let markers = L.layerGroup([]);

navigator.geolocation.getCurrentPosition((position) => {
    currentPosition = [position.coords.latitude, position.coords.longitude];

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    map.setView(currentPosition);

    renderCurrentPosition(currentPosition);
});

document.querySelector('#geoloc-target').addEventListener('click', ev => {
    navigator.geolocation.getCurrentPosition((position) => {
        currentPosition = [position.coords.latitude, position.coords.longitude];

        map.flyTo(currentPosition);
        markersCurrentPosition.clearLayers();
        renderCurrentPosition(currentPosition);
    })
});

function renderCurrentPosition(currentPosition) {

    let circleOuter = L.circleMarker(currentPosition, {
        color: 'rgba(6,63,116,0)',
        fillColor: '#063f74',
        fillOpacity: 0.3,
        radius: 30,
    })

    let circleInner = L.circleMarker(currentPosition, {
        color: '#ffffff',
        fillColor: '#6ddff3',
        fillOpacity: 1,
        radius: 10
    })

    markersCurrentPosition
        .addLayer(circleOuter)
        .addLayer(circleInner)
        .addTo(map);
}

function renderPins(pins) {
    pins.forEach(el => {
        markers.addLayer(el);
    });
}
