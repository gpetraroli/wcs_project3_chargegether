const form = document.querySelector('form');

form.addEventListener('change', updateView);

function updateView() {
    const startDateTime =
        form.querySelector('#booking_startRes_date_day').value + '-' +
        form.querySelector('#booking_startRes_date_month').value + '-' +
        form.querySelector('#booking_startRes_date_year').value + ' ' +
        form.querySelector('#booking_startRes_time_hour').value + ':' +
        form.querySelector('#booking_startRes_time_minute').value;

    const endDateTime =
        form.querySelector('#booking_endRes_date_day').value + '-' +
        form.querySelector('#booking_endRes_date_month').value + '-' +
        form.querySelector('#booking_endRes_date_year').value + ' ' +
        form.querySelector('#booking_endRes_time_hour').value + ':' +
        form.querySelector('#booking_endRes_time_minute').value;

    const vehicleId = form.querySelector('#booking_vehicle').value;

    const stationId = form.querySelector('#booking_station').value;

    fetch(`/api/price/${startDateTime}/${endDateTime}/${vehicleId}/${stationId}`)
        .then(res => res.json())
        .then(data => {
            document.querySelector('#start-date-time').innerHTML = startDateTime;
            document.querySelector('#end-date-time').innerHTML = endDateTime;
            document.querySelector('#fees').innerHTML = data['fees'].toFixed(2) +' €';
            document.querySelector('#price').innerHTML = data['price'].toFixed(2) +' €';
            document.querySelector('#total').innerHTML = `${(data['price'] + data['fees']).toFixed(2)} €`;
        });

    document.querySelector('button').addEventListener('click', (event)=>{
        event.target.classList.add('disabled');
    });
}
