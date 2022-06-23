const plugEls = document.querySelectorAll('.plug-type-item');
const powerEls = document.querySelectorAll('.station-power-item');

const plugTypeSel = document.querySelector('#station_plugType');
const powerSel = document.querySelector('#station_power');

const checkPlugEl = document.createElement('i');
const checkPowerEl = document.createElement('i');
checkPlugEl.classList.add('bi', 'bi-check-lg', 'text-primary');
checkPowerEl.classList.add('bi', 'bi-check-lg', 'text-primary');

plugEls.forEach(plug => {
    plug.addEventListener('click', () => {
        plugEls.forEach(plug => {
            plug.classList.remove('selected');
        });
        plug.classList.add('selected');
        plug.appendChild(checkPlugEl);
        plugTypeSel.value = plug.dataset.plugType;
    })
});

powerEls.forEach(power => {
    power.addEventListener('click', () => {
        powerEls.forEach(power => {
            power.classList.remove('selected');
        });
        power.classList.add('selected');
        power.appendChild(checkPowerEl);
        powerSel.value = power.dataset.stationPower;
    })
});
