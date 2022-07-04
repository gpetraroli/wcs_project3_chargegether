const stationAddress = document.querySelector('#station_address');
const btnSubmitStation = document.querySelector('#station_enregistrer');
const coordinates = document.querySelector('#station_coordinates');
const form = document.querySelector('form');

btnSubmitStation.addEventListener('click', ev => {
    ev.preventDefault();

    const address = stationAddress.value;
    fetch(`https://maps.googleapis.com/maps/api/geocode/json?address=${address}&key=AIzaSyD9Ymmg4k3WlkkA4hlom351Yp1tn3nhOeY`)
        .then(data => data.json())
        .then((locationData) => {
            coordinates.value = [locationData['results'][0]['geometry']['location']['lat'], locationData['results'][0]['geometry']['location']['lng']];
            form.submit();
        });
})
