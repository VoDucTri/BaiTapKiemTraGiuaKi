<?php
include '../config/database.php';
session_start();

if (isset($_GET['MaDK']) && isset($_GET['MaHP'])) {
    $MaDK = $_GET['MaDK'];
    $MaHP = $_GET['MaHP'];

    $sql = "DELETE FROM ChiTietDangKy WHERE MaDK='$MaDK' AND MaHP='$MaHP'";
    if ($conn->query($sql) === TRUE) {
        header("Location: giohang.php");
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>
