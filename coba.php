<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Pencarian Berdasarkan Rentang Tanggal</title>
</head>

<body>
    <form action="" method="post">
        <label for="start_date">Tanggal Mulai (YYYY-MM-DD):</label>
        <input type="date" id="start_date" name="start_date" required>
        <br>
        <label for="end_date">Tanggal Akhir (YYYY-MM-DD):</label>
        <input type="date" id="end_date" name="end_date" required>
        <br>
        <button type="submit">Cari</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require 'config/connection.php';

        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        // Validasi tanggal
        if (strtotime($start_date) > strtotime($end_date)) {
            echo '<p>Tanggal mulai tidak boleh lebih besar dari tanggal akhir.</p>';
        } else {
            // Query untuk mencari berdasarkan rentang tanggal dan JOIN dengan tabel guru dan kelas
            $sql = "SELECT a.hari_tanggal, u.nama AS nama_guru_piket, a.guru_tdk_hadir, k.nama_kelas AS kelas, a.jam_ke, a.sampai, a.uraian
            FROM absensi a
            JOIN users u ON a.nama_guru_piket = u.id
            JOIN kelas k ON a.kelas = k.id
            WHERE a.hari_tanggal BETWEEN :start_date AND :end_date";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['start_date' => $start_date, 'end_date' => $end_date]);

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($results) {
                echo '<h2>Hasil Pencarian:</h2>';
                echo '<table border="1">';
                echo '<tr><th>Nama Guru</th><th>Kelas</th><th>Tanggal</th></tr>';
                foreach ($results as $row) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['nama_guru_piketb']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['kelas']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['hari_tanggal']) . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo '<p>Tidak ada data yang ditemukan dalam rentang tanggal tersebut.</p>';
            }
        }
    }
    ?>
</body>

</html>


