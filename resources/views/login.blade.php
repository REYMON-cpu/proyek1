<?php
session_start();
include 'koneksi.php';

$email = $_POST['email'];
$password = $_POST['password'];

$query = mysqli_query($conn, "SELECT * FROM user WHERE email='$email'");
$data = mysqli_fetch_array($query);

if($data){
    if($password == $data['password']){

        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['role'] = $data['role'];

        header("Location: dashboard.php");

    } else {
        echo "Password salah!";
    }
} else {
    echo "Email tidak ditemukan!";
}
?>