<?php
session_start();
include('security.php');
include('includes/header.php');
include('includes/navbar.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$selected_bulan = $_POST['bulan'];

// Koneksi ke database
$connection = new mysqli($server_name, $db_username, $db_password, $db_name);

// Memeriksa koneksi
if ($connection->connect_error) {
    die("Koneksi gagal: " . $connection->connect_error);
}

// SQL untuk menghitung jumlah mobil berdasarkan bulan yang dipilih
$sql = "SELECT SUM(jumlah_mobil) as total_mobil FROM data_parkir WHERE bulan = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("s", $selected_bulan);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_mobil = $row['total_mobil'];
} else {
    $total_mobil = 0;
}

$stmt->close();
$connection->close();
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tabel Data</h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Download File Excel
        </a> -->
    </div>

    <!-- Form untuk memilih bulan -->
    <div class="card shadow mb-4">
        
    <!-- <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pilih Bulan</h6>
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="bulan">Bulan:</label>
                    <select name="bulan" id="bulan" class="form-control" required>
                        <option value="">Pilih Bulan</option>
                        <option value="01" <?php if($selected_bulan == "01") echo 'selected'; ?>>Januari</option>
                        <option value="02" <?php if($selected_bulan == "02") echo 'selected'; ?>>Februari</option>
                        <option value="03" <?php if($selected_bulan == "03") echo 'selected'; ?>>Maret</option>
                        <option value="04" <?php if($selected_bulan == "04") echo 'selected'; ?>>April</option>
                        <option value="05" <?php if($selected_bulan == "05") echo 'selected'; ?>>Mei</option>
                        <option value="06" <?php if($selected_bulan == "06") echo 'selected'; ?>>Juni</option>
                        <option value="07" <?php if($selected_bulan == "07") echo 'selected'; ?>>Juli</option>
                        <option value="08" <?php if($selected_bulan == "08") echo 'selected'; ?>>Agustus</option>
                        <option value="09" <?php if($selected_bulan == "09") echo 'selected'; ?>>September</option>
                        <option value="10" <?php if($selected_bulan == "10") echo 'selected'; ?>>Oktober</option>
                        <option value="11" <?php if($selected_bulan == "11") echo 'selected'; ?>>November</option>
                        <option value="12" <?php if($selected_bulan == "12") echo 'selected'; ?>>Desember</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div> -->

    <!-- Menampilkan hasil jumlah mobil -->
    <!-- <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Jumlah Mobil Berdasarkan Bulan</h6>
        </div>
        <div class="card-body">
            <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
                <h4>Total jumlah mobil pada bulan <?php echo $selected_bulan; ?> adalah: <?php echo $total_mobil; ?></h4>
            <?php endif; ?>
        </div>
    </div> -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">Data Tabel</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Jumlah Mobil</th>
                            <th>Jam</th>
                            <th>Tanggal</th>
                            <th>Bulan</th>
                            <th>Tahun</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Koneksi ke database
                        $connection = new mysqli($server_name, $db_username, $db_password, $db_name);

                        // Memeriksa koneksi
                        if ($connection->connect_error) {
                            die("Koneksi gagal: " . $connection->connect_error);
                        }

                        // SQL untuk mengambil data dari tabel data_parkir
                        $sql = "SELECT id, jumlah_mobil, jam, tanggal, bulan, tahun FROM data_parkir ORDER BY tahun DESC, bulan DESC, tanggal DESC, jam DESC";
                        $result = $connection->query($sql);

                        if ($result && $result->num_rows > 0) {
                            // Output data dari setiap baris
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td>" . $row["jumlah_mobil"] . "</td>";
                                echo "<td>" . $row["jam"] . "</td>";
                                echo "<td>" . $row["tanggal"] . "</td>";
                                echo "<td>" . $row["bulan"] . "</td>";
                                echo "<td>" . $row["tahun"] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>Tidak ada data ditemukan</td></tr>";
                        }

                        $connection->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</div>
<?php 
include('includes/footer.php');
include('includes/scripts.php');
?>