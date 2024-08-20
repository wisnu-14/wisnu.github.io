<?php
session_start();
require 'functions/functionUsers.php';
require 'functions/functionsAbsensi.php';
$username = $_SESSION['username'];
$user = getUserByUsername($username);
if (!$user) {
    echo "Data pengguna tidak ditemukan.";
    exit;
}
cekLogin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurnal Piket</title>
    <link rel="stylesheet" href="asset/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="asset/img/smk.png">
    <link rel="shortcut icon" href="asset/img/smk.png">
    <style>
        .form-container {
            display: none;
            transition: 0.5s ease-out;
        }

        .form-container.active {
            display: block;
        }

        .profile-container {
            margin-bottom: 20px;
        }

        th,
        td {
            word-wrap: break-word;
            overflow-wrap: break-word;
            white-space: normal;
        }

        .logout-icon {
            font-size: 1.5rem;
            color: grey;
            cursor: pointer;
        }

        .logout-icon:hover {
            color: #a71d2a;
        }
    </style>

</head>

<body style="font-size: 14px;">
    <?php if ($_SESSION['role'] == 'admin') : ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#">
                <img src="asset/img/smklogo.png" width="30" height="30" class="d-inline-block align-top" alt="">
                WebApp
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="?page=profile">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="piketDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Piket
                        </a>
                        <div class="dropdown-menu" aria-labelledby="piketDropdown">
                            <a class="dropdown-item" href="?page=piket">Data Piket</a>
                            <a class="dropdown-item" href="?page=rekap">Rekap Data</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="guruDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Manajemen Guru
                        </a>
                        <div class="dropdown-menu" aria-labelledby="guruDropdown">
                            <a class="dropdown-item" href="?page=dataGuru">Data Guru</a>
                            <a class="dropdown-item" href="?page=resetPassword">Reset Password Guru</a>
                        </div>
                    </li>
                </ul>
                <span class="navbar-text ml-auto d-flex align-items-center">
                    <span class="badge bg-primary text-white p-2 mr-2" style="font-size: 14px;">
                        <i class="bi bi-person-circle"></i>
                    </span>
                    <span style="margin-right: 10px;">
                        Login sebagai: <strong><?php echo $user['nama']; ?></strong>
                    </span>
                    <a href="logout.php" onclick="return confirm('Yakin ingin logout?');" class="d-flex align-items-center"
                        data-bs-toggle="tooltip" data-bs-placement="bottom" title="Logout">
                        <i class="bi bi-box-arrow-right logout-icon"></i>
                    </a>
                </span>
            </div>
        </nav>
    <?php else : ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <img src="asset/img/smklogo.png" width="30" height="30" class="d-inline-block align-top" alt="">
            WebApp
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="?page=profile">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="piketDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Piket
                        </a>
                        <div class="dropdown-menu" aria-labelledby="piketDropdown">
                            <a class="dropdown-item" href="?page=piket">Data Piket</a>
                            <a class="dropdown-item" href="?page=rekap">Rekap Data</a>
                        </div>
                    </li>
                </ul>
                <span class="navbar-text ml-auto d-flex align-items-center">
                    <span class="badge bg-primary text-white p-2 mr-2" style="font-size: 14px;">
                        <i class="bi bi-person-circle"></i>
                    </span>
                    <span style="margin-right: 10px;">
                        Login sebagai: <strong><?php echo $user['nama']; ?></strong>
                    </span>
                    <a href="logout.php" onclick="return confirm('Yakin ingin logout?');" class="d-flex align-items-center"
                        data-bs-toggle="tooltip" data-bs-placement="bottom" title="Logout">
                        <i class="bi bi-box-arrow-right logout-icon"></i>
                    </a>
                </span>
            </div>
        </nav>
    <?php endif; ?>
    <div class="container-fluid">
        <?php require 'config/ini.php'; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleEditForm() {
            var formContainer = document.getElementById('edit-form-container');
            formContainer.classList.toggle('active');
        }

        function printPage() {
            window.print();
        }
    </script>
</body>

</html>