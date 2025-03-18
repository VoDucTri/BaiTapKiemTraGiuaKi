<?php
include '../config/database.php';

if (isset($_GET['MaSV'])) {
    $MaSV = $_GET['MaSV'];
    $sql = "SELECT * FROM SinhVien WHERE MaSV='$MaSV'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết Sinh Viên</title>
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
        img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #ddd;
        }
        .btn {
            display: block;
            margin-top: 15px;
            padding: 8px;
            text-decoration: none;
            color: white;
            background: #007BFF;
            border-radius: 5px;
        }
        .btn:hover {
            background: #0056b3;
        }
        .text-muted {
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Chi tiết Sinh Viên</h2>
        <p><strong>Mã SV:</strong> <?= htmlspecialchars($row['MaSV']) ?></p>
        <p><strong>Họ Tên:</strong> <?= htmlspecialchars($row['HoTen']) ?></p>
        <p><strong>Giới Tính:</strong> <?= htmlspecialchars($row['GioiTinh']) ?></p>
        <p><strong>Ngày Sinh:</strong> <?= htmlspecialchars($row['NgaySinh']) ?></p>
        <p>
            <?php
            $image_path = "../upload/images/" . htmlspecialchars($row['Hinh']);
            $server_path = __DIR__ . "/../upload/images/" . htmlspecialchars($row['Hinh']);
            if (!empty($row['Hinh']) && file_exists($server_path)) {
                echo '<img src="' . htmlspecialchars($image_path, ENT_QUOTES, 'UTF-8') . '" alt="Ảnh sinh viên">';
            } else {
                echo '<p class="text-muted">Không có ảnh</p>';
            }
            ?>
        </p>
        <a href="index.php" class="btn">Quay lại danh sách</a>
    </div>
</body>
</html>