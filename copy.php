<?php
error_reporting(1);
require 'functions/functionsAbsensi.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap</title>
    <link rel="stylesheet" href="asset/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        @media print {
            @page {
                size: landscape;
            }

            .no-print {
                display: none;
            }

            .nama {
                display: none;
            }

            form {
                display: none;
            }

            .form-search {
                display: none;
            }

            body,
            * {
                color: black;
            }

            .tanggal {
                display: none;
            }

            .tombol-kembali {
                display: none;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                border: 1px solid black !important;
                table-layout: fixed;
                border: 1px solid black;
            }

            th,
            td {
                border: 1px solid black !important;
                padding: 8px !important;
                text-align: left;
                background-color: white !important;
                /* Remove Bootstrap background */
            }

            th {
                font-weight: bold !important;
            }

            /* Remove Bootstrap table class styles */
            .table-bordered,
            .table-hover,
            .table-css {
                border: none;
            }

            .table-bordered th,
            .table-bordered td {
                border: none;
            }
        }
    </style>
</head>

<body>
    <div class="p-2 bg-primary text-white text-center">
        <p>JURNAL PIKET KBM <br>
            SMK NEGERI 2 PURBALINGGA <br>
            SEMESTER GANJIL <br>
            TAHUN PELAJARAN 2024/2025 <br>
        </p>
    </div>
    <div class="container">
        <div class="container mt-5 form-search">
            <h2 class="mb-4">Filter Data</h2>
            <form action="" method="POST" class="row g-3" target="_blank">
                <div class="col-md-4">
                    <label for="start_date" class="form-label">Dari tanggal</label>
                    <input type="date" id="start_date" name="tanggal_awal" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">Sampai</label>
                    <input type="date" id="end_date" name="tanggal_akhir" class="form-control" required>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div>
        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tanggal_awal = $_POST['tanggal_awal'];
            $tanggal_akhir = $_POST['tanggal_akhir'];
        ?>
            <?php if (strtotime($tanggal_awal) > strtotime($tanggal_akhir)) { ?>
                <p>Tanggal mulai tidak boleh lebih besar dari tanggal akhir</p>
            <?php } else {
                $sql = "SELECT a.hari_tanggal, u.nama AS nama_guru_piket, a.guru_tdk_hadir, k.nama_kelas AS kelas, a.jam_ke, a.sampai, a.uraian
                FROM absensi a
                JOIN users u ON a.nama_guru_piket = u.id
                JOIN kelas k ON a.kelas = k.id
                WHERE a.hari_tanggal BETWEEN :tanggal_awal AND :tanggal_akhir";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir]);

                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            ?>
                <?php if ($results) { ?>
                    <img src="asset/img/printLogo.png" alt="" onclick="printPage()" class="img no-print mb-2 mt-3 " width="30px" style="cursor: pointer;">
                    <div class="card mt-2 ">
                        <div class="card-header tanggal">
                            Rekap Absensi tanggal <?= htmlspecialchars($tanggal_awal) ?> sampai tanggal <?= htmlspecialchars($tanggal_akhir) ?>
                        </div>
                        <div class="card-body text-center">
                            <table class="table table-bordered  table-bordered-black table-hover ">
                                <thead class="bg-primary" style="color: white;">
                                    <tr>
                                        <th scope="col" style="width: 7%;">No</th>
                                        <th scope="col">Hari/Tanggal</th>
                                        <th scope="col">Nama <br> Guru Piket</th>
                                        <th scope="col">Guru <br> Tidak Hadir</th>
                                        <th scope="col" style="width: 8%;">Kelas</th>
                                        <th scope="col" style="width: 8%;">Jam</th>
                                        <th scope="col" style="width: 40%;">Uraian</th>
                                    </tr>
                                </thead>
                                <?php
                                $i = 1;
                                foreach ($results as $data) :
                                ?>
                                    <tbody>
                                        <tr>
                                            <th scope="row"><?php echo $i ?></th>
                                            <td><?php echo $data['hari_tanggal']; ?></td>
                                            <td><?php echo $data['nama_guru_piket']; ?></td>
                                            <td><?php echo $data['guru_tdk_hadir'] ?></td>
                                            <td><?php echo $data['kelas']; ?></td>
                                            <td><?php echo $data['jam_ke'] ?> - <?php echo $data['sampai'] ?></td>
                                            <td><?php echo $data['uraian'] ?></td>
                                        </tr>
                                    </tbody>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            </table>
                            <?php if (count($results) > 0): ?>
                                <form action="rekapPrint.php" method="GET" target="_blank">
                                    <input type="hidden" name="start_date" value="<?= htmlspecialchars($start_date); ?>">
                                    <input type="hidden" name="end_date" value="<?= htmlspecialchars($end_date); ?>">
                                    <button type="submit" class="btn btn-secondary">Print</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php } else { ?>
                    <p class="text-danger">data tidak ada</p>
                <?php } ?>
            <?php } ?>
        <?php } ?>
        <div class="col-3 mt-3 tombol-kembali">
            <a href="./" class="btn btn-primary">kembali</a>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function toggleEditForm() {
        var formContainer = document.getElementById('edit-form-container');
        formContainer.classList.toggle('active');
    }

    function printPage() {
        window.print();
    }
</script>

</html>