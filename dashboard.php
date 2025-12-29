<?php
include 'config.php';
include 'auth/check_login.php'; // Wajib, cek apakah user sudah login

// Fungsi untuk membuat sidebar admin, agar reusable
function include_sidebar($active_page = '') {
    $base_url = BASE_URL;
    echo "
    <aside class='sidebar-admin'>
        <div class='sidebar-header'>
            <h3>Admin BPBD Jatim</h3>
        </div>
        <nav class='sidebar-nav'>
            <a href='{$base_url}dashboard.php' class='" . ($active_page == 'dashboard' ? 'active' : '') . "'>
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'><path d='M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L8.707 1.5Z'/><path d='M12.5 16a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm-3.5-2a.5.5 0 0 0-.5.5v1h-1a.5.5 0 0 0 0 1h1v1a.5.5 0 0 0 1 0v-1h1a.5.5 0 0 0 0-1h-1v-1a.5.5 0 0 0-.5-.5Z'/></svg>
                Dashboard
            </a>
            <a href='{$base_url}modules/warehouse/list.php' class='" . ($active_page == 'warehouse' ? 'active' : '') . "'>
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'><path d='m.875 10.025.046-.046.002.002.006.006.01.01.018.018.028.028.04.04.051.051.063.063.075.075.087.087.098.098.11.11.12.12.132.132.143.143.153.153h.001c.219.219.559.418.915.58C3.321 15.42 4.902 16 8 16c3.098 0 4.679-.58 5.754-1.252.356-.162.696-.361.915-.58h.001l.153-.153.143-.143.132-.132.12-.12.11-.11.098-.098.087-.087.075-.075.063-.063.051-.051.04-.04.028-.028.018-.018.01-.01.006-.006.002-.002.046.046.002.002a.5.5 0 0 0-.708-.708l-.002-.002-.046-.046-.002-.002-.006-.006-.01-.01-.018-.018-.028-.028-.04-.04-.051-.051-.063-.063-.075-.075-.087-.087-.098-.098-.11-.11-.12-.12-.132-.132-.143-.143-.153-.153c-.219-.219-.559-.418-.915-.58C12.679 8.58 11.098 8 8 8c-3.098 0-4.679.58-5.754 1.252-.356.162-.696.361-.915-.58l-.153.153-.143.143-.132.132-.12.12-.11.11-.098.098-.087.087-.075.075-.063.063-.051.051-.04.04-.028.028-.018.018-.01.01-.006.006-.002.002-.046.046a.5.5 0 0 0 .708.708l.002-.002Z'/></svg>
                Manajemen Gudang
            </a>
            <a href='{$base_url}modules/wms/items_list.php' class='" . ($active_page == 'wms' ? 'active' : '') . "'>
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'><path d='M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z'/></svg>
                Manajemen WMS
            </a>
            <a href='{$base_url}modules/warehouse/optimize_location.php' class='" . ($active_page == 'optimize' ? 'active' : '') . "'>
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'><path d='M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z'/><path d='M8.5 5.5a.5.5 0 0 0-1 0v1.5H6a.5.5 0 0 0 0 1h1.5V9.5a.5.5 0 0 0 1 0V8H10a.5.5 0 0 0 0-1H8.5V5.5z'/></svg>
                Optimasi Lokasi
            </a>
        </nav>
        <div class='sidebar-footer'>
            <a href='{$base_url}logout.php' class='btn btn-danger'>Logout</a>
        </div>
    </aside>
    ";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - BPBD Jatim WMS</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
</head>
<body class="admin-page">

    <?php include_sidebar('dashboard'); // Panggil sidebar ?>

    <main class="main-admin-content">
        <header class="admin-header">
            <h2>Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
            <p>Ini adalah halaman utama dashboard Anda.</p>
        </header>

        <section class="admin-content">
            <div class="widget-grid">
                
                <div class="widget-card">
                    <h3>Gudang Terdaftar</h3>
                    <?php
                        $result = $conn->query("SELECT COUNT(*) as total FROM warehouses");
                        $row = $result->fetch_assoc();
                        echo "<h1>" . $row['total'] . "</h1>";
                    ?>
                    <a href="<?php echo BASE_URL; ?>modules/warehouse/list.php" class="card-link">Lihat Detail</a>
                </div>

                <div class="widget-card">
                    <h3>Jenis Item Logistik</h3>
                    <?php
                        $result = $conn->query("SELECT COUNT(*) as total FROM items");
                        $row = $result->fetch_assoc();
                        echo "<h1>" . $row['total'] . "</h1>";
                    ?>
                    <a href="<?php echo BASE_URL; ?>modules/wms/items_list.php" class="card-link">Lihat Detail</a>
                </div>

                <div class="widget-card">
                    <h3>Total Stok (Unit)</h3>
                    <?php
                        $result = $conn->query("SELECT SUM(stock) as total FROM items");
                        $row = $result->fetch_assoc();
                        echo "<h1>" . (int)$row['total'] . "</h1>";
                    ?>
                    <a href="<?php echo BASE_URL; ?>modules/wms/items_list.php" class="card-link">Lihat Detail</a>
                </div>

            </div>
        </section>
    </main>

</body>
</html>