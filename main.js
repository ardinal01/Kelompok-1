// ========== INIT MAP ==========
let map = L.map('map').setView([-7.250445, 112.768845], 8);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 20,
    attribution: '&copy; OpenStreetMap'
}).addTo(map);

let geojsonLayer;
let disasterLayer;

// ========== LOAD GEOJSON WILAYAH ==========
async function loadGeoJSON(city) {
    if (geojsonLayer) map.removeLayer(geojsonLayer);

    const url = `assets/geojson/kecamatan_${city}.geojson`;

    let response = await fetch(url);
    let data = await response.json();

    geojsonLayer = L.geoJson(data, {
        style: {
            color: "#005eff",
            weight: 2,
            fillColor: "#80bfff",
            fillOpacity: 0.5
        }
    }).addTo(map);

    map.fitBounds(geojsonLayer.getBounds());
}

// ========== LOAD CUACA ==========
async function loadWeather(city) {
    let res = await fetch(`modules/weather/weather_api.php?city=${city}`);
    let data = await res.json();

    document.getElementById("weatherInfo").innerHTML = `
        <b>${city.toUpperCase()}</b><br>
        Suhu: ${data.temp}°C<br>
        Kondisi: ${data.description}<br>
        Kelembaban: ${data.humidity}%
    `;
}

// ========== LOAD CSV BENCANA ==========
async function loadDisasterCSV() {
    const years = [2021, 2022, 2023, 2024];
    let dataset = [];

    for (let y of years) {
        let res = await fetch(`historis_bencana/bencana_${y}.csv`);
        let text = await res.text();

        let rows = text.split("\n").slice(1);

        rows.forEach(r => {
            let col = r.split(",");

            if (col.length < 6) return;

            let obj = {
                kota: col[0],
                longsor: parseInt(col[5] || 0),
                banjir: parseInt(col[6] || 0)
            };
            dataset.push(obj);
        });
    }

    return dataset;
}

// ========== ZONA WARNA ==========
function getColor(value) {
    if (value >= 50) return "red";      // zona merah
    if (value >= 20) return "yellow";   // zona kuning
    return "green";                     // zona hijau
}

// ========== OVERLAY RISIKO BENCANA ==========
async function overlayDisaster(city) {
    if (disasterLayer) map.removeLayer(disasterLayer);

    let dataset = await loadDisasterCSV();

    // cari data kota
    let filtered = dataset.filter(d => d.kota.toLowerCase() === city);

    if (filtered.length === 0) {
        document.getElementById("disasterInfo").innerHTML = "Tidak ada data bencana.";
        return;
    }

    // hitung skor risiko
    let totalLongsor = filtered.reduce((a, b) => a + b.longsor, 0);
    let totalBanjir = filtered.reduce((a, b) => a + b.banjir, 0);
    let skor = totalLongsor + totalBanjir;

    document.getElementById("disasterInfo").innerHTML = `
        <b>${city.toUpperCase()}</b><br>
        Total Longsor: ${totalLongsor}<br>
        Total Banjir: ${totalBanjir}<br>
        <b>Skor Risiko: ${skor}</b>
    `;

    // WARNAI GEOJSON
    disasterLayer = L.geoJson(geojsonLayer.toGeoJSON(), {
        style: {
            color: getColor(skor),
            weight: 2,
            fillColor: getColor(skor),
            fillOpacity: 0.6
        }
    }).addTo(map);
}

// ========== EVENT HANDLER ==========
document.getElementById("selectCity").addEventListener("change", async function () {
    let city = this.value;
    if (!city) return;
    await loadGeoJSON(city);
});

document.getElementById("btnLoadWeather").onclick = async () => {
    let city = document.getElementById("selectCity").value;
    if (!city) return alert("Pilih kota terlebih dahulu.");
    loadWeather(city);
};

document.getElementById("btnLoadDisaster").onclick = async () => {
    let city = document.getElementById("selectCity").value;
    if (!city) return alert("Pilih kota dahulu.");
    overlayDisaster(city);
};

// ========== GUDANG TERDEKAT (DUMMY) ==========
document.getElementById("btnMyLocation").onclick = () => {
    alert("Fitur gudang terdekat terhubung ke database — siap setelah integrasi.");
};
