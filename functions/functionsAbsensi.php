<?php
require 'config/connection.php';

function getOptionsKelas()
{
        global $pdo;
        $sql = "SELECT id, nama_kelas FROM kelas";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getOptionsNamaGuru()
{
        global $pdo;
        $sql = "SELECT id, nama FROM users";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getAllAbsensi()
{
        global $pdo;
        $sql = "SELECT a.id, a.hari_tanggal, u.nama AS nama_guru_piket, a.guru_tdk_hadir, k.nama_kelas, a.jam_ke, a.sampai, a.uraian
                FROM absensi a
                JOIN kelas k ON a.kelas = k.id
                JOIN users u ON a.nama_guru_piket = u.id ORDER BY a.hari_tanggal ASC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getAbsensiById($id)
{
        global $pdo;
        $sql = "SELECT * FROM absensi WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
}
function getAbsensi()
{
        global $pdo;
        $sql = "SELECT * FROM absensi";
        $stmt = $pdo->prepare($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
}
function hapusDataDariAbsensi($id)
{
        global $pdo;
        $sql = "DELETE FROM absensi WHERE nama_guru_piket = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
}
function hapusDataAbsensi($id)
{
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM absensi WHERE id = :id");
        $stmt->execute(['id' => $id]);
}

// Fungsi untuk menghapus data pengguna
function hapusData($id)
{
        hapusDataDariAbsensi($id); // Hapus data terkait di tabel absensi
        global $pdo;
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
}
function rekapPerHari($tanggal)
{
        global $pdo;
        $sql = "SELECT * FROM absensi WHERE hari_tanggal = :tanggal";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(([':tanggal' => $tanggal]));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getDataByDate($tgl1, $tgl2)
{
        global $pdo;

        $stmt = $pdo->prepare("SELECT * FROM absensi WHERE hari_tanggal BETWEEN '$tgl1' and '$tgl2' ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function rekapPerTahun($tahun)
{
        global $pdo;
        $sql = "SELECT a.hari_tanggal, u.nama AS nama_guru_piket, a.guru_tdk_hadir, k.nama_kelas AS kelas, a.jam_ke, a.sampai, a.uraian
        FROM absensi a
        JOIN users u ON a.nama_guru_piket = u.id
        JOIN kelas k ON a.kelas = k.id
        WHERE YEAR(a.hari_tanggal) = :tahun";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':tahun' => $tahun]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function hitungTotalData()
{
        global $pdo;
        $sqlUsers = "SELECT COUNT(*) FROM users";
        $stmtUsers = $pdo->prepare($sqlUsers);
        $stmtUsers->execute();
        $totalUsers = $stmtUsers->fetchColumn();

        $sqlAbsensi = "SELECT COUNT(*) FROM absensi ";
        $stmtAbsensi = $pdo->prepare($sqlAbsensi);
        $stmtAbsensi->execute();
        $totalAbsensi = $stmtAbsensi->fetchColumn();

        $sqlKelas = "SELECT COUNT(*) FROM kelas";
        $stmtKelas = $pdo->prepare($sqlKelas);
        $stmtKelas->execute();
        $totalKelas = $stmtKelas->fetchColumn();

        // Menghitung total semua data
        $totalSemua = $totalUsers + $totalAbsensi + $totalKelas;

        return [
                'totalUsers' => $totalUsers,
                'totalAbsensi' => $totalAbsensi,
                'totalKelas' => $totalKelas,
                'totalSemua' => $totalSemua
        ];
}

function totalGuruTdkHadir()
{
        global $pdo;
        $sqlGuruTidakHadir = "SELECT COUNT(guru_tdk_hadir) FROM absensi ";
        $stmtGuruTidakHadir = $pdo->prepare($sqlGuruTidakHadir);
        $stmtGuruTidakHadir->execute();
        $totalGuruTidakHadir = $stmtGuruTidakHadir->fetchColumn();

        return ['totalGuruTidakHadir' => $totalGuruTidakHadir];
}

function totalKelas()
{
        global $pdo;
        $sqlTotalKelas = "SELECT COUNT(*) FROM kelas";
        $stmtTotalKelas = $pdo->prepare($sqlTotalKelas);
        $stmtTotalKelas->execute();
        $totalKelas = $stmtTotalKelas->fetchColumn();

        return ['totalKelas' => $totalKelas];
}

function totalAkun()
{
        global $pdo;
        $sqlTotalAkun = "SELECT COUNT(nama) FROM users";
        $stmtTotalAkun = $pdo->prepare($sqlTotalAkun);
        $stmtTotalAkun->execute();
        $totalAkun = $stmtTotalAkun->fetchColumn();

        return ['totalAkun' => $totalAkun];
}


function simpanDataAbsensi($nama_guru_piket, $hari_tanggal, $guru_tdk_hadir, $kelas, $jam_ke, $sampai, $uraian, $edit, $id)
{
        global $pdo;
        if ($edit == 1 && !empty($id)) {
                $stmt = $pdo->prepare("UPDATE absensi SET 
                                nama_guru_piket = :nama_guru_piket,
                                hari_tanggal = :hari_tanggal,
                                guru_tdk_hadir = :guru_tdk_hadir,
                                kelas = :kelas,
                                jam_ke = :jam_ke,
                                sampai = :sampai,
                                uraian = :uraian
                                WHERE id = :id
                            ");
                $stmt->execute([
                        'nama_guru_piket' => $nama_guru_piket,
                        'hari_tanggal' => $hari_tanggal,
                        'guru_tdk_hadir' => $guru_tdk_hadir,
                        'kelas' => $kelas,
                        'jam_ke' => $jam_ke,
                        'sampai' => $sampai,
                        'uraian' => $uraian,
                        'id' => $id
                ]);
        } else {
                $stmt = $pdo->prepare("INSERT INTO absensi (hari_tanggal, nama_guru_piket, guru_tdk_hadir, kelas, jam_ke, sampai, uraian) VALUES (:hari_tanggal, :nama_guru_piket, :guru_tdk_hadir, :kelas, :jam_ke, :sampai, :uraian)");
                $stmt->execute([
                        'nama_guru_piket' => $nama_guru_piket,
                        'hari_tanggal' => $hari_tanggal,
                        'guru_tdk_hadir' => $guru_tdk_hadir,
                        'kelas' => $kelas,
                        'jam_ke' => $jam_ke,
                        'sampai' => $sampai,
                        'uraian' => $uraian
                ]);
        }
}


function rekap($tanggal_awal, $tanggal_akhir)
{
        global $pdo;
        $sql = "SELECT a.hari_tanggal, u.nama AS nama_guru_piket, a.guru_tdk_hadir, k.nama_kelas AS kelas, a.jam_ke, a.sampai, a.uraian
        FROM absensi a
        JOIN users u ON a.nama_guru_piket = u.id
        JOIN kelas k ON a.kelas = k.id
        WHERE a.hari_tanggal BETWEEN :tanggal_awal AND :tanggal_akhir";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir]);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
}
