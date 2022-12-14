export function renderStationInfo(station)
{
    const stationInfoEl = document.querySelector('#station-info');
    stationInfoEl.classList.remove('d-none');
    const stationInfoMakup = `
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="d-flex flex-column gap-1">
                <h2 id='js-name' class="text-secondary d-flex gap-2 m-0"><img src="/images/logo_hote.png">${station.owner}</h2>
                <p class="m-0">
                    <a href="/hote/avis/${station.id}" class="text-decoration-none">
                        ${String('<i class="bi bi-star-fill text-warning"></i>').repeat(station.avg)}${String('<i class="bi bi-star-half text-warning"></i>').repeat(Math.round(station.avg%1))}
                    </a>
                    (${station.reviewCount} avis)
                </p>
            </div>
            <i id='btn-close' class="bi bi-x-circle fs-2"></i>
        </div>
        <div class="d-flex justify-content-between w-100">
            <div class="col-4 d-flex justify-content-start">
                <img style="height: 70px" src="/images/stations/plugs/${station.type}.png">
            </div>
            <div class="col-4 d-flex flex-column align-items-center">
                <img style="height: 60px" src="/images/parking.png">
                <p class="text-center text-secondary fw-bold">privé</p>
            </div>
            <div class="col-4 d-flex justify-content-end">
                <img style="height: 70px" src="images/stations/power/borne${station.power}kw.png">
            </div>
        </div>
        <a href="/hote/reserver/${station.id}" class="btn btn-secondary fs-2 rounded-pill col-6">Réserver</a>
    `;

    stationInfoEl.innerHTML = stationInfoMakup;

    stationInfoEl.querySelector('#btn-close').addEventListener('click', dismissStationInfo);
}

function dismissStationInfo()
{
    const stationInfoEl = document.querySelector('#station-info');
    stationInfoEl.classList.add('d-none');
}
