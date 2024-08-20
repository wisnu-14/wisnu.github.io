<?php 
error_reporting(1);

$server = 'localhost';
$dbname = 'absensi';
$username = 'root';
$password = '';

try{
    $pdo = new PDO("mysql:host=$server;dbname=$dbname",$username,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    die("koneksi ke database gagal: ".$e->getMessage());
}