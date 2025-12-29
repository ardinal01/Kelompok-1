<?php
// Mulai session di file config agar tersedia di semua halaman
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 1. Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); // Password XAMPP default biasanya kosong
define('DB_NAME', 'bpbd');

// 2. OpenWeatherMap API Key
// GANTI DENGAN API KEY ANDA!
define('OPENWEATHER_API_KEY', 'GANTI_DENGAN_API_KEY_ANDA'); 

// 3. Base URL
// Mengdeteksi http atau https dan host
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
// Path root dari wms.com
$script_name = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
// Menghapus sub-direktori (jika script dipanggil dari 'modules')
$base_path = preg_replace('/modules\/[a-zA-Z0-9_-]+\//', '', $script_name);
define('BASE_URL', $protocol . '://' . $host . $base_path);


// Buat koneksi MySQLi
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi Database Gagal: " . $conn->connect_error);
}

// Set charset ke utf8mb4
$conn->set_charset("utf8mb4");

?>