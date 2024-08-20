<?php 
error_reporting(0);

switch($_GET['page']){
    case "profile":
        require "profile.php";
    break;
    case "dataGuru":
        require "dataGuru.php";
    break;
    case "rekapHarian":
        require "rekapHarian.php";
    break;
    case "piket":
        require "piket.php";
    break;
    case "rekap":
        require "rekap.php";
    break;
    case "resetPassword":
        require "reset.php";
    break;
    default:
    require 'profile.php';
}
?>