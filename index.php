<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BPBD Jawa Timur - Monitoring & WMS</title>
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhpmFAdCprPkn8LRVBcjzPBTsDYT4GM1EWOg=" crossorigin=""/>
    
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
    
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>
<body class="public-page">

    <header class="main-header">
        <div class="container">
            <h1><img src="https://bpbd.jatimprov.go.id/templates/yootheme/cache/logo-bpbd-jatim-b-02b11d88.png" alt="Logo BPBD" class="logo"> Monitoring BPBD Jawa Timur</h1>
            <nav>
                <a href="<?php echo BASE_URL; ?>login.php" class="btn btn-primary">Login Admin</a>
            </nav>
        </div>
    </header>

    <main class="container main-content">
        
        <div class="map-container">
            <div id="map"></div>
            <div id="map-info-box" class="map-info">Hover di atas kecamatan</div>
        </div>

        <div class="sidebar">
            
            <div class="widget weather-widget">
                <h2>Cuaca Realtime</h2>
                <select id="city-selector">
                    <option value="1625822">Surabaya</option> <option value="1636694">Malang</option>
                    <option value="1633434">Pasuruan</option>
                    <option value="1625516">Sidoarjo</option>
                </select>
                <div id="weather-info">
                    <p>Pilih kota untuk melihat cuaca...</p>
                </div>
            </div>

            <div class="widget nearest-widget">
                <h2>Cari Gudang Terdekat</h2>
                <button id="find-nearest-btn" class="btn btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                    </svg>
                    Gunakan Lokasi Saya
                </button>
                <div id="nearest-info" class="info-box"></div>
            </div>
            
        </div>
    </main>

    <script>
        // Definisikan BASE_URL untuk JavaScript
        const BASE_URL = '<?php echo BASE_URL; ?>';
    </script>
    <script src="<?php echo BASE_URL; ?>assets/js/main.js"></script>

</body>
</html>