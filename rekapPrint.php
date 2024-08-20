<?php
error_reporting(0);
require 'functions/functionsAbsensi.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Rekap</title>
    <link rel="icon" type="image/x-icon" href="asset/img/smk.png">
    <link rel="shortcut icon" href="asset/img/smk.png">
</head>
<style>
    h1 {
        font-size: 25px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 16px;
        min-width: 400px;
    }

    th,
    td {
        padding: 12px;
        border: 1px solid #000000;
        text-align: center;
    }

    .no {
        padding-inline: 1px;
    }

    .uraian-cell {
        word-wrap: break-word;
        word-break: break-word;
        word-wrap: break-word;
        word-break: break-word;
        max-width: 900px;
    }

    .judul {
        text-align: center;
        margin-bottom: 50px;
    }

    .guru_tdk_hadir {
        padding-inline: 0;
    }

    .nama_guru_piket {
        padding-inline: 0;

    }

    @media screen and (max-width: 600px) {
        table {
            width: 100%;
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }

        th,
        td {
            white-space: normal;
        }
    }

    @media print {
        @page {
            size: landscape;
        }
        .logo-print{
            display: none;
        }
    }
</style>

<body>
    <div class="judul">
        <h1>JURNAL PIKET KBM <br>
            SMK NEGERI 2 PURBALINGGA <br>
            SEMESTER GANJIL <br>
            TAHUN PELAJARAN 2024/2025
        </h1>
    </div>
    <?php
    $tanggal_awal = $_GET['tanggal_awal'];
    $tanggal_akhir = $_GET['tanggal_akhir'];
    ?>
    <?php if (strtotime($tanggal_awal) > strtotime($tanggal_akhir)) { ?>
        <p>Tanggal mulai tidak boleh lebih besar dari tanggal akhir</p>
    <?php } else {
        $results = rekap($tanggal_awal, $tanggal_akhir);
    ?>
        <div class="container">
            <?php if ($results) { ?>
                <div class="logo">
                    <img src="asset/img/print.png" class="logo-print" onclick="printPage()" alt="" width="40px" style="cursor: pointer;">
                </div>
                <table border="1">
                    <thead>
                        <tr>
                            <th class="no">No</th>
                            <th>Hari/Tanggal</th>
                            <th class="nama_guru_piket">Nama Guru Piket</th>
                            <th class="guru_tdk_hadir">Guru Tidak Hadir</th>
                            <th>Kelas</th>
                            <th>Jam</th>
                            <th>Uraian</th>
                        </tr>
                    </thead>
                    <?php
                    $i = 1;
                    foreach ($results as $data) :
                    ?>
                        <tbody>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $data['hari_tanggal']; ?></td>
                                <td><?php echo $data['nama_guru_piket']; ?></td>
                                <td><?php echo $data['guru_tdk_hadir']; ?></td>
                                <td><?php echo $data['kelas']; ?></td>
                                <td><?php echo $data['jam_ke'] ?> - <?php echo $data['sampai'] ?></td>
                                <td class="uraian-cell"><?php echo $data['uraian']; ?></td>
                            </tr>
                        </tbody>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </table>
        </div>

    <?php } else { ?>
        <p class="text-danger">data tidak ada</p>
    <?php } ?>
<?php } ?>
</body>
<script>
       function printPage() {
        window.print();
    }
</script>
</html>