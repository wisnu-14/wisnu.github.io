    <div class="container">
        <div class="container mt-5 form-search">
            <h2 class="mb-4">Filter Data</h2>
            <form method="POST" class="row g-3">
                <div class="col-md-4">
                    <label for="start_date" class="form-label">Dari tanggal</label>
                    <input type="date" id="start_date" name="tanggal_awal" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">Sampai</label>
                    <input type="date" id="end_date" name="tanggal_akhir" class="form-control" required>
                </div>
                <div class="col-md-4 d-flex align-items-end mt-3">
                    <button type="submit" class="btn btn-light">
                        <img src="asset/img/filter.png" alt="" width="20" height="20">
                    </button>
                </div>
            </form>
        </div>
        <?php
        $tanggal_awal = $_POST['tanggal_awal'];
        $tanggal_akhir = $_POST['tanggal_akhir'];
        ?>
        <?php if (strtotime($tanggal_awal) > strtotime($tanggal_akhir)) { ?>
            <p>Tanggal mulai tidak boleh lebih besar dari tanggal akhir</p>
        <?php } else {
            $results = rekap($tanggal_awal, $tanggal_akhir);
        ?>
            <?php if ($results) { ?>
                <div class="card mt-5 ">
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
                    </div>
                </div>
            <?php } else { ?>
                <p class="text-danger text-center mt-2">data tidak ada</p>
            <?php } ?>
        <?php } ?>
        <div class="d-flex">
            <?php if (count($results) > 0): ?>
                <form action="rekapPrint.php" method="GET" target="_blank">
                    <input type="hidden" name="tanggal_awal" value="<?= htmlspecialchars($tanggal_awal); ?>">
                    <input type="hidden" name="tanggal_akhir" value="<?= htmlspecialchars($tanggal_akhir); ?>">
                    <button type="submit" class="btn btn-dark px-3">Print</button>
                </form>
            <?php endif; ?>
            <button onclick="window.history.back()" class="btn btn-dark " style="margin-left: 10px;">Kembali</button>
        </div>
    </div>