<?php

userAdmin();
 
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role     = $_POST['role'];
    $edit = $_POST['editz'];
    $id = $_POST['idz'];
    setDataUser($nama,$nip,$username,$password,$role,$edit,$id);
    header("Location: ./?page=dataGuru");
}

if($_GET['edit']==1){
    global $pdo;
    $idd = "$_GET[id]";
    $sql = "SELECT * FROM users WHERE id=$idd";
    $stmt = $pdo->query($sql);
    $row = $stmt->fetch();
    $readOnly = "readonly";
}
?>
<?php

if (isset($_GET['hapus'])) {
    $id = $_GET['id'];
    deleteData($id);
}
?>
<div class="container mt-5">
    <div class="card-body">
        <form method="post" action="./?page=dataGuru">
            <div class="form-row align-items-center">
                <div class="form-group col-md-3">
                    <label for="nip">NIP</label>
                    <input type="text" class="form-control" name="nip" id="nip" placeholder="Masukkan NIP" value="<?php echo $row['nip']; ?>">
                </div>
                <div class="form-group col-md-3">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan Nama" value="<?php echo $row['nama']; ?>">
                </div>
                <div class="form-group col-md-3">
                    <label for="mapel">Username</label>
                    <input type="text" class="form-control" name="username" id="mapel" placeholder="Masukkan Username" value="<?php echo $row['username']; ?>">
                </div>
                <div class="form-group col-md-3">
                    <label for="mapel">Password</label>
                    <input type="password" class="form-control" name="password" id="mapel" placeholder="Masukkan Password" <?php echo $readOnly ;?> value="">
                </div>
                <div class="form-group col-md-3">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role">
                            <option value="Pilih" disabled selected>Pilih</option>
                            <option value="admin" <?php if ($row['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                            <option value="guru" <?php if ($row['role'] == 'guru') echo 'selected'; ?>>Guru</option>
                        </select>
                </div>
                    <input type="hidden" name="editz" value="<?php echo $_GET['edit']; ?>">
                    <input type="hidden" name="idz" value="<?php echo $row['id']; ?>">
                    <button type="submit" class="btn btn-dark form-control">Simpan Perubahan</button>
            </div>
        </form>
    <?php
    $user = menampilkanDataUser();
    ?>
    <div class="card mt-5 table-responsive">
        </div>
        <div class="card-header">
            Data Guru
        </div>
        <div class="card-body text-center ">
            <table class="table table-bordered table-hover ">
                <thead>
                    <tr class="bg-primary" style="color: white;">
                        <th scope="col">No</th>
                        <th scope="col">NIP</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Username</th>
                        <th scope="col">Role</th>
                        <th scope="col">Aksi</th>   
                    </tr>
                </thead>
                <?php
                    $i = 1;
                foreach ($user as $data) :
                ?>
                    <tbody>
                        <tr>
                            <th scope="row"><?php echo $i++ ?></th>
                            <td><?php echo $data['nip']; ?></td>
                            <td><?php echo $data['nama']; ?></td>
                            <td><?php echo $data['username']; ?></td>
                            <td><?php echo $data['role']; ?></td>
                            <td>
                                <a href="./?page=dataGuru&edit=1&id=<?php echo $data['id'] ?>"  class="btn-group" style="margin-right: 5px;" >
                                    <img src="asset/img/edit.png" alt="" width="25px" height="auto" class="img" >
                                </a>
                                <a href="./?page=dataGuru&hapus&id=<?php echo $data['id'] ?>" onclick="return confirm('YAKIN HAPUS DATA?!!');" class="btn-group">
                                    <img src="asset/img/delete.png" alt="" width="25px" height="auto" class="img">
                                </a>
                            </td>
                        </tr>
                    </tbody>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>