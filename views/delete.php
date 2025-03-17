<?php
include '../config/database.php';

if (isset($_GET['MaSV'])) {
    $MaSV = $_GET['MaSV'];
    $sql = "DELETE FROM SinhVien WHERE MaSV='$MaSV'";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "<p class='error'>Lỗi: " . $conn->error . "</p>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Xóa Sinh Viên</title>
</head>
<body>
    <script>
        alert("Sinh viên đã được xóa thành công!");
        window.location.href = "index.php";
    </script>
</body>
</html>
