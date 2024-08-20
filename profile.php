<?php
error_reporting(1);
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];
$user = getUserByUsername($username);
if (!$user) {
    echo "Data pengguna tidak ditemukan.";
    exit;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nip = $_POST['nip'];
    $name = $_POST['nama'];
    $username = $_POST['username'];

    if (updateUser($nip, $name, $username)) {
        $message = "Data berhasil diperbarui.";
        $user = getUserByUsername($username);
        header('Location: ./');
    } else {
        $message = "Gagal memperbarui data.";
    }
}

$akunMasuk = totalAkun();
$hasil = hitungTotalData();
$guru = totalGuruTdkHadir();
$kelas = totalKelas();
?>
<div class="container mt-5">
    <div class="profile-header">Dashboard</div>
    <div class="row text-center">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow-sm " style="border-radius: 50px;">
                <div class="card-body bg-primary" style="color: white;  box-shadow: 0px 0px 11px 0px rgba(0,0,0,0.75); border-radius: 10px;">
                    <h5 class="card-title">User Masuk</h5>
                    <h2 class="card-text"><?php echo $akunMasuk['totalAkun'] ?></h2>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4 ">
            <div class="card shadow-sm " style="border-radius: 50px;">
                <div class="card-body bg-primary" style="color: white;  box-shadow: 0px 0px 11px 0px rgba(0,0,0,0.75); border-radius: 10px;">
                    <h5 class="card-title">Jumlah Kelas</h5>
                    <h2 class="card-text"><?php echo $kelas['totalKelas'] ?></h2>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow-sm " style="border-radius: 50px;">
                <div class="card-body bg-primary" style="color: white; box-shadow: 0px 0px 11px 0px rgba(0,0,0,0.75); border-radius: 10px;">
                    <h5 class="card-title">Guru Tidak Hadir</h5>
                    <h2 class="card-text"><?php echo $guru['totalGuruTidakHadir'] ?></h2>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow-sm " style="border-radius: 50px;">
                <div class="card-body bg-primary" style="color: white;  box-shadow: 0px 0px 11px 0px rgba(0,0,0,0.75); border-radius: 10px;">
                    <h5 class="card-title">Data Masuk</h5>
                    <h2 class="card-text"><?php echo $hasil['totalSemua'] ?></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-muted">
        Terakhir diperbarui: <?php echo date('Y-m-d H:i:s'); ?>
    </div>
</div>

<div class="container profile-container">

    <div class="row">
        <div class="col-sm-6 mb-3 mb-sm-0">

            <div class="card">
                <div class="card-body">
                    <div class="profile-header">Profil Pengguna</div>
                    <div class="profile-details bg-primary" style="border-radius: 5px; color: white;">
                        <div class="row mb-3">
                            <div class="col-md-4 profile-label">Nama:</div>
                            <div class="col-md-8 text-center" id="nama"><?php echo $user['nama']; ?></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 profile-label">NIP:</div>
                            <div class="col-md-8 text-center" id="nip"><?php echo $user['nip']; ?></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 profile-label">Username:</div>
                            <div class="col-md-8 text-center" id="username"><?php echo $user['username']; ?></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 profile-label">Role:</div>
                            <div class="col-md-8 text-center" id="role"><?php echo $user['role']; ?></div>
                        </div>
                    </div>
                    <a href="#" class="btn btn-dark mt-3" onclick="toggleEditForm()">Edit Profile</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body" style="background-color: #e6e6e6; border-radius: 5px;">
                    <div id="edit-form-container" class="form-container">
                        <div class="profile-header pt-3">Edit Profile</div>
                        <form method="post" action="?page=profile">
                            <div class="form-group">
                                <label for="username">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($user['nama']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="username">NIP</label>
                                <input type="text" class="form-control" id="nip" name="nip" value="<?php echo htmlspecialchars($user['nip']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="username">Password</label>
                                <input type="password" class="form-control" id="password" name="password" value="<?php echo htmlspecialchars($user['password']); ?>">
                            </div>
                            <div class="pb-3">
                                <button type="submit" class="btn btn-dark" name="update_profile">Update</button>
                                <button type="button" class="btn btn-dark" onclick="toggleEditForm()">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>