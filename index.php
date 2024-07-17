<?php
session_start();
include('security.php');
if (!$_SESSION['username']) {
    header('Location: login.php');
    exit();
}
include('includes/header.php');
include('includes/navbar.php');

// Mendapatkan tanggal, bulan dan tahun saat ini
$currentDate = date('d');
$currentMonth = date('m');
$currentYear = date('Y');

// Memeriksa koneksi
if ($connection->connect_error) {
    die("Koneksi gagal: " . $connection->connect_error);
}

// SQL untuk menghitung jumlah mobil pada bulan ini
$sqlMonth = "SELECT COUNT(jumlah_mobil) AS total_mobil_bulan FROM data_parkir WHERE bulan = '$currentMonth' AND tahun = '$currentYear'";
$resultMonth = $connection->query($sqlMonth);

// Mengambil hasil query untuk bulan ini
$total_mobil_bulan = 0;
if ($resultMonth && $resultMonth->num_rows > 0) {
    $rowMonth = $resultMonth->fetch_assoc();
    $total_mobil_bulan = $rowMonth['total_mobil_bulan'];
}

// SQL untuk menghitung jumlah mobil pada hari ini
$sqlToday = "SELECT COUNT(jumlah_mobil) AS total_mobil_hari_ini FROM data_parkir WHERE tanggal = '$currentDate' AND bulan = '$currentMonth' AND tahun = '$currentYear'";
$resultToday = $connection->query($sqlToday);

// Mengambil hasil query untuk hari ini
$total_mobil_hari_ini = 0;
if ($resultToday && $resultToday->num_rows > 0) {
    $rowToday = $resultToday->fetch_assoc();
    $total_mobil_hari_ini = $rowToday['total_mobil_hari_ini'];
}

// SQL untuk menghitung jumlah mobil setiap bulan dalam setahun terakhir
$data_bulanan = array_fill(0, 12, 0);  // Array default dengan 12 bulan
for ($i = 1; $i <= 12; $i++) {
    $sql = "SELECT COUNT(jumlah_mobil) AS total_mobil_bulan FROM data_parkir WHERE bulan = '$i' AND tahun = '$currentYear'";
    $result = $connection->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $data_bulanan[$i - 1] = $row['total_mobil_bulan'];
    }
}

// Menutup koneksi
$connection->close();
?>
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <a href="table.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                            <i class="fas fa-table fa-sm text-white-50"></i> Tabel Data
                        </a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Jumlah Mobil Bulan Ini</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_mobil_bulan; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-2">
                                                Total Mobil Hari Ini</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_mobil_hari_ini; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pengunjung Bulan Ini
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-info" role="progressbar"
                                                            style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Total Hari Ini</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-12 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Jumlah Mobil</h6>
                                    <!-- <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div> -->
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myAreaChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php 
include('includes/scripts.php');
include('includes/footer.php');
?>
