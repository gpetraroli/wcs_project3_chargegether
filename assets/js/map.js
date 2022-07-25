/*global google*/
import {renderStationInfo} from './station-info-widget';

let map;
let currentPositionMarker;

function initMap()
{
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
    renderStations();
}// initMap

window.initMap = initMap;

function setCurrentPosition()
{
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((position) => {
            const pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude,
            }
            map.setCenter(pos);
            currentPositionMarker = new google.maps.Marker({
                position: pos,
                icon: "/images/cible.png",
                map: map,
            });
        },() => {
            handleLocationError()
        });
    } else {
        handleLocationError();
    }
}

function renderStations()
{
    fetch('/api/hotes')
        .then(data => data.json())
        .then(stations => {
            stations.forEach(station => {
                let marker = new google.maps.Marker({
                    position: station,
                    icon: "/images/pin.png",
                    map: map,
                });
                marker.addListener("click", () => {
                    renderStationInfo(station);
                });
            });
        });
}

function handleLocationError(browserHasGeolocation, infoWindow, pos)
{
    // TODO: handle location errors
}
