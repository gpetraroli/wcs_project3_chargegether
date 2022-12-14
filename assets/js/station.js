const plugEls = document.querySelectorAll('.plug-type-item');
const powerEls = document.querySelectorAll('.station-power-item');

const plugTypeSel = document.querySelector('#station_plugType');
const powerSel = document.querySelector('#station_power');

plugEls.forEach(plug => {
    plug.addEventListener('click', () => {
        plugEls.forEach(plug => {
            plug.classList.remove('selected');
        });
        plug.classList.add('selected');

        plugTypeSel.value = plug.dataset.plugType;
    })
});

powerEls.forEach(power => {
    power.addEventListener('click', () => {
        powerEls.forEach(power => {
            power.classList.remove('selected');
        });
        power.classList.add('selected');
        powerSel.value = power.dataset.stationPower;
    })
});

(function init()
{
    plugEls.forEach(plug => {
        plug.classList.remove('selected');
        if (plug.dataset.plugType === plugTypeSel.value) {
            plug.classList.add('selected');
        }
    });

    powerEls.forEach(power => {
        power.classList.remove('selected');
        if (power.dataset.stationPower === powerSel.value) {
            power.classList.add('selected');
        }
    });
})();
