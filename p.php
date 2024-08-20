<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Navbar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">WebApp</a>
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
                    <a class="dropdown-item" href="rekap.php" target="_blank">Rekap Data</a>
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
            <!-- Teks Login Sebagai -->
            <span class="badge bg-primary text-white p-2 mr-2" style="font-size: 14px;">
                <i class="bi bi-person-circle"></i>
            </span>
            <span>
                Login sebagai: <strong><?php echo $user['nama']; ?></strong>
            </span>
            <!-- Tombol Logout -->
            <a class="btn btn-outline-danger ml-3" href="logout.php" onclick="return confirm('Yakin ingin logout?');">Logout</a>
        </span>
    </div>
</nav>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
