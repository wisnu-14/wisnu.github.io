<?php
userAdmin();
$user = getUsernames();
if (!$user) {
    echo "<script>alert('data tidak ditemukan')</script>";
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $userId = $_POST['userId'];
    $newPassword = $_POST['newPassword'];
    resetUserPassword($userId, $newPassword);
}
?>
<style>
    .management-container {
        margin: 20px;
    }

    .management-header {
        font-size: 24px;
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: bold;
    }
</style>
</head>
<div class="container mt-5">
    <h2>Reset Password User</h2>
    <form action="?page=resetPassword" method="POST">
        <div class="form-group">
            <label for="userId">Username</label>
            <select class="form-control" id="userId" name="userId" required>
                <option value="" disabled selected>Pilih Username</option>
                <?php foreach ($user as $user) : ?>
                    <option value="<?php echo htmlspecialchars($user['id']); ?>">
                        <?php echo htmlspecialchars($user['nama']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="newPassword">Password Baru</label>
            <input type="password" class="form-control" id="newPassword" name="newPassword" required placeholder="Masukan Password Baru">
        </div>
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
        <button type="submit" class="btn btn-dark">Reset Password</button>
        <a href="?page=profile" class="btn btn-dark">Home</a>
    </form>
</div>