/*global google*/
import {calcRoute, initDirectionService} from './directions';

let map;

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

    initDirectionService(map);

    navigator.geolocation.getCurrentPosition((position) => {
        const pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude,
        }

        calcRoute(pos, document.querySelector('#start-navigation').dataset.destination);
    },() => {
        handleLocationError()
    });


}// initMap

window.initMap = initMap;

function handleLocationError(browserHasGeolocation, infoWindow, pos)
{
    // TODO: handle location errors
}
