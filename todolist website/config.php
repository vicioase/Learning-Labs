<?php
$host = 'localhost';
$dbname = 'todo_db';
$username = 'root';
$password = '';

// Membuat koneksi
$conn = mysqli_connect($host, $username, $password, $dbname);

// Cek koneksi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>