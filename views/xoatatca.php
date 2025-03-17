<?php
include '../config/database.php';
session_start();

if (isset($_SESSION['MaSV'])) {
    $MaSV = $_SESSION['MaSV'];

    // Xóa tất cả các học phần của sinh viên đó
    $sql = "DELETE FROM ChiTietDangKy WHERE MaDK IN (SELECT MaDK FROM DangKy WHERE MaSV='$MaSV')";
    if ($conn->query($sql) === TRUE) {
        header("Location: giohang.php");
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>
