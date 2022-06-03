import {Loader} from "@googlemaps/js-api-loader"

const googleApiKey = document.querySelector('#map').dataset.google_api_key;
const loader = new Loader({
    apiKey: googleApiKey,
    version: "weekly",
});

let map;
let currentPositionMarker;

loader.load().then(renderMap);

function renderMap() {
    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 15,
        disableDefaultUI: true,
        zoomControl: true,
        mapTypeControl: true,
        scaleControl: true,
        rotateControl: true,
    });

    const locationButton = document.querySelector('#geoloc-target');
    locationButton.addEventListener('click', setCurrentPosition);
    map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(locationButton);

    setCurrentPosition();
}// renderMap

function setCurrentPosition() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((position) => {
            const pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude,
            }
            map.setCenter(pos);
            currentPositionMarker = new google.maps.Marker({
                position: pos,
                map: map,
            });
        },() => {
            handleLocationError()
        });
    } else {
        handleLocationError();
    }
}

function handleLocationError(browserHasGeolocation, infoWindow, pos)
{
    // TODO: handle location errors
}
