<?php
include '../config/database.php';

if (isset($_GET['MaSV'])) {
    $MaSV = $_GET['MaSV'];
    $sql = "SELECT * FROM SinhVien WHERE MaSV='$MaSV'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $HoTen = $_POST['HoTen'];
    $GioiTinh = $_POST['GioiTinh'];
    $NgaySinh = $_POST['NgaySinh'];
    $Hinh = $_POST['Hinh'];
    $MaNganh = $_POST['MaNganh'];

    $sql = "UPDATE SinhVien SET HoTen='$HoTen', GioiTinh='$GioiTinh', NgaySinh='$NgaySinh', Hinh='$Hinh', MaNganh='$MaNganh' WHERE MaSV='$MaSV'";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "<p class='error'>Lỗi: " . $conn->error . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Sinh Viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
        }
        .container {
            width: 400px;
            margin: auto;
            padding: 20px;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 50px;
        }
        .form-group {
            text-align: left;
            margin-bottom: 10px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            width: 100%;
            padding: 10px;
            background: #ffc107;
            color: black;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .btn:hover {
            background: #e0a800;
        }
        .back-btn {
            display: block;
            margin-top: 10px;
            text-decoration: none;
            color: white;
            background: #007BFF;
            padding: 8px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Sửa Sinh Viên</h2>
        <form method="post">
            <div class="form-group">
                <input type="text" name="HoTen" value="<?= htmlspecialchars($row['HoTen']) ?>" required>
            </div>
            <div class="form-group">
                <input type="text" name="GioiTinh" value="<?= htmlspecialchars($row['GioiTinh']) ?>" required>
            </div>
            <div class="form-group">
                <input type="date" name="NgaySinh" value="<?= htmlspecialchars($row['NgaySinh']) ?>" required>
            </div>
            <input type="file" name="Hinh" accept="image/*"><br>
            <div class="form-group">
                <input type="text" name="MaNganh" value="<?= htmlspecialchars($row['MaNganh']) ?>" required>
            </div>
            <button type="submit" class="btn">Cập nhật</button>
        </form>
        <a href="index.php" class="back-btn">Quay lại danh sách</a>
    </div>
</body>
</html>
