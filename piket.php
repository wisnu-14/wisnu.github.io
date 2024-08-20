<?php
$username = $_SESSION['username'];
$user = getUserByUsername($username);
if (!$user) {
    echo "Data pengguna tidak ditemukan.";
    exit;
}
cekLogin();
userAdmin();
if (!$user) {
    echo "<script>alert('data tidak ditemukan')</script>";
}
$guru_options = getOptionsNamaGuru();
$kelas_options = getOptionsKelas();
$absensi_list = getAllAbsensi();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_guru_piket = $_POST['nama_guru_piket'];
    $hari_tanggal = $_POST['hari_tanggal'];
    $guru_tdk_hadir = $_POST['guru_tdk_hadir'];
    $kelas = $_POST['kelas'];
    $jam_ke    = $_POST['jam_ke'];
    $sampai = $_POST['sampai'];
    $uraian = $_POST['uraian'];
    $edit = isset($_POST['edit']) ? $_POST['edit'] : 0;
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    // echo $hari_tanggal ."<br>". $guru_tdk_hadir ."<br>". $kelas ."<br>". $jam_ke ."<br>". $sampai ."<br>". $uraian;
    simpanDataAbsensi($nama_guru_piket, $hari_tanggal, $guru_tdk_hadir, $kelas, $jam_ke, $sampai, $uraian, $edit, $id);
    header("Location: ./?page=piket");
    exit;
}

if ($_GET['edit'] == 1) {
    $id = "$_GET[id]";
    $row = getAbsensiById($id);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    hapusDataAbsensi($id);
    header('Location: ./?page=piket');
}

?>

<div class="container mt-5">
    <div class="card-body">
        <div class="profile-header" id="form-title">Input Data</div>
        <form method="post" action="./?page=piket">
            <div class="form-row align-items-center">
                <input type="hidden" name="id" id="id" value="<?php echo htmlspecialchars($id); ?>">
                <div class="form-group col-md-3">
                    <label for="namaGuru">Hari/Tanggal</label>
                    <input type="date" class="form-control" name="hari_tanggal" id="hari_tanggal" value="<?php echo $row['hari_tanggal']; ?>">
                </div>
                <div class="form-group col-md-3">
                    <label for="role">Nama Guru Piket</label>
                    <select class="form-control" id="guru" name="nama_guru_piket" required>
                        <option value="" disabled selected>Pilih nama anda</option>
                        <?php foreach ($guru_options as $guru) : ?>
                            <?php if ($guru['id'] == $row['nama_guru_piket']) : ?>
                                <option value="<?php echo $guru['id']; ?>" selected>
                                    <?php echo htmlspecialchars($guru['nama']); ?>
                                </option>
                            <?php else : ?>
                                <option value="<?php echo $guru['id']; ?>">
                                    <?php echo htmlspecialchars($guru['nama']); ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="mapel">Guru Tidak Hadir</label>
                    <input type="text" class="form-control" id="guru_tdk_hadir" name="guru_tdk_hadir" id="mapel" placeholder="Masukan Nama Guru " value="<?php echo $row['guru_tdk_hadir']; ?>">
                </div>
                <div class="form-group">
                    <label for="catatan">Uraian</label>
                    <textarea class="form-control" name="uraian" id="uraian" rows="1" placeholder="Uraian ..."><?php echo $row['uraian']; ?></textarea>
                </div>
                <div class="form-group col-md-3">
                    <label for="role">Kelas</label>
                    <select class="form-control" id="guru" name="kelas" required>
                        <option value="" disabled selected>Pilih Kelas</option>
                        <?php foreach ($kelas_options as $kelas) : ?>
                            <?php if ($kelas['id'] == $row['kelas']) : ?>
                                <option value="<?php echo $kelas['id']; ?>" selected>
                                    <?php echo htmlspecialchars($kelas['nama_kelas']); ?>
                                </option>
                            <?php else : ?>
                                <option value="<?php echo $kelas['id']; ?>">
                                    <?php echo htmlspecialchars($kelas['nama_kelas']); ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="input1">Jam</label>
                    <div class="row no-gutters">
                        <div class="col-sm-3" style="margin-right: 5px;">
                            <input type="number" class="form-control" name="jam_ke" id="jam_ke" placeholder="Jam ke" value="<?php echo $row['jam_ke']; ?>">
                        </div>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" name="sampai" id="sampai" placeholder="Sampai" value="<?php echo $row['sampai']; ?>">
                        </div>
                    </div>
                </div>
                <input type="hidden" name="edit" value="<?php $_GET['edit'] ?>">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                <button type="submit" id="submit-btn" class="btn btn-dark form-control">Simpan Perubahan</button>
            </div>
        </form>
        <div class="card mt-5 table-responsive">
            <div class="card-header">
                Data Piket
            </div>
            <div class="card-body text-center ">
                <table class="table table-bordered table-hover ">
                    <thead class="bg-primary text-light">
                        <tr>
                            <th scope="col" style="width: 7%;">No</th>
                            <th scope="col">Hari/Tanggal</th>
                            <th scope="col">Nama <br> Guru Piket</th>
                            <th scope="col">Guru <br> Tidak Hadir</th>
                            <th scope="col">Kelas</th>
                            <th scope="col" style="width: 8%;">Jam</th>
                            <th scope="col" style="width: 20%;">Uraian</th>
                            <th scope="col" style="width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <?php
                    $i = 1;
                    foreach ($absensi_list as $data) :
                    ?>
                        <tbody>
                            <tr>
                                <th scope="row"><?php echo $i; ?></th>
                                <td><?php echo $data['hari_tanggal']; ?></td>
                                <td><?php echo $data['nama_guru_piket']; ?></td>
                                <td><?php echo $data['guru_tdk_hadir'] ?></td>
                                <td><?php echo $data['nama_kelas']; ?></td>
                                <td><?php echo $data['jam_ke'] ?> - <?php echo $data['sampai'] ?></td>
                                <td><?php echo $data['uraian'] ?></td>
                                <td>
                                    <a href="./?page=piket&edit=1&id=<?php echo $data['id'] ?>" class="btn-group">
                                        <img src="asset/img/edit.png" alt="" width="25px" height="auto" class="img-thumbnail">
                                    </a>
                                    <a href="./?page=piket&hapus&id=<?php echo $data['id'] ?>" class="btn-group">
                                        <img src="asset/img/delete.png" alt="" width="25px" height="auto" class="img-thumbnail">
                                    </a>
                                </td>
                            </tr>
                        </tbody>

                    <?php $i++;
                    endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</div>