<?php
session_start();
require 'functions/functionUsers.php';
jikaSudahLogin();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (loginUser($username, $password)) {
        header("Location: ./");
        exit;
    } else {
        echo '<script>alert("USERNAME ATAU PASSWORD SALAH")</script>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css" />
</head>
<style>
    body,
    html {
        height: 80%;
        margin: 0;
        background-color: #f0f2f5;
    }

    .container {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card {
        width: 100%;
        max-width: 400px;
        border: none;
        border-radius: 10px;
        box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
    }

    .card-header,
    .card-body {
        border: none;
        border-radius: 0;
    }

    .btn-primary {
        width: 100%;
        border-radius: 0;
    }

    .form-control {
        border-radius: 0;
    }
</style>

<body>
    <div class="container-fluid p-4 bg-primary text-white text-center">
        <h1 class="pb-2 font-weight-normal">APLIKASI ABSENSI PIKET</h1>
        <h3 class="font-weight-light">SMKN 2 PURBALINGGA</h3>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h3>Login</h3>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>