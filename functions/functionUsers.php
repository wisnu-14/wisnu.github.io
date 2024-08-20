<?php

require 'config/connection.php';
function loginUser($username,$password){
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($user && password_verify($password,$user['password'])){
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        return true;
    }else{
        return false;
    }
}
function setDataUser($nama,$nip,$username,$password,$role,$edit,$id){
    global $pdo;
    if($edit === 1 && !empty($id)){
        $stmt = $pdo->prepare("UPDATE users SET 
                                nip='$nip',
                                nama='$nama',
                                username='$username',
                                password='$password',
                                role='$role'
                                WHERE id='$id'
                            ");
                                $stmt->execute([
                                    'nama' =>$nama,
                                    'nip' =>$nip,
                                    'username' =>$username,
                                    'role' =>$role,
                                    'id' =>$id
                                ]);
    }else{
        $hashed_password = password_hash($password,PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (nama,nip,username,password,role) VALUES (:nama,:nip,:username,:password,:role)");
        $stmt->execute([
            'nama' =>$nama,
            'nip' =>$nip,
            'username' =>$username,
            'password' =>$hashed_password,
            'role' =>$role
        ]);
    }
}

function deleteData($id){
    global $pdo;
    $sql = "DELETE FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();   
}


function menampilkanDataUser(){
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users ORDER BY nip ASC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getUserByUsername($username) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getUserById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function userAdmin() {
    if(!isset($_SESSION['username']) && $_SESSION['role'] == 'admin'){
        header("Location: ./");
    }
}

function jikaSudahLogin(){
    if (isset($_SESSION['username'])) {
        if (userAdmin()) {
            header("Location: ./");
        } else {
            header("Location: login.php");
        }
        exit;
    }
}

function cekLogin(){
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
        exit;
    }
}

function updateUser($nip, $name, $username) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    
    if ($count > 1) {
        return false; 
    }

    $sql = "UPDATE users SET nip = :nip, nama = :nama, username = :username WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nip', $nip);
    $stmt->bindParam(':nama', $name);
    $stmt->bindParam(':username', $username);
    return $stmt->execute();
}

function getUsernames() {
    global $pdo;
    $sql = "SELECT id, nama FROM users";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function resetUserPassword( $userId, $newPassword) {
    global $pdo;
    try {
        // Hash password baru
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Query untuk mengupdate password
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        // Menjalankan query dengan parameter yang diikat
        $stmt->execute([
            ':password' => $hashedPassword,
            ':id' => $userId,
        ]);

        // Pesan sukses
        echo "Password berhasil direset.";
    } catch (PDOException $e) {
        // Tangani kesalahan query
        echo "Error: " . $e->getMessage();
    }
}
