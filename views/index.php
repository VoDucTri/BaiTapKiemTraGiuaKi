<?php
include '../config/database.php';

$sql = "SELECT * FROM SinhVien";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách Sinh Viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 20px;
            background-color: #f4f4f4;
        }
        h2 {
            color: #333;
        }
        .container {
            width: 80%;
            margin: auto;
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background: white;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background: #007BFF;
            color: white;
        }
        img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .btn {
            padding: 8px 12px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
            font-size: 14px;
            display: inline-block;
            margin: 5px;
        }
        .btn-green { background: #28a745; }
        .btn-yellow { background: #ffc107; color: black; }
        .btn-red { background: #dc3545; }
        .btn-green:hover { background: #218838; }
        .btn-yellow:hover { background: #e0a800; }
        .btn-red:hover { background: #c82333; }
        .btn-container {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Danh sách Sinh Viên</h2>
        <div class="btn-container">
            <a href="create.php" class="btn btn-green">Thêm Sinh Viên</a>
            <a href="../index.php" class="btn btn-red">Về Trang Chủ</a>
        </div>

        <table>
            <tr>
                <th>Mã SV</th>
                <th>Họ Tên</th>
                <th>Giới Tính</th>
                <th>Ngày Sinh</th>
                <th>Hình</th>
                <th>Hành động</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['MaSV'] ?></td>
                <td><?= $row['HoTen'] ?></td>
                <td><?= $row['GioiTinh'] ?></td>
                <td><?= $row['NgaySinh'] ?></td>
                <td>
    <?php
    if (!empty($row['Hinh']) && file_exists("upload/" . $row['Hinh'])) {
        echo '<img src="upload/' . htmlspecialchars($row['Hinh']) . '" alt="Hình sinh viên" width="50">';
    } else {
        echo '<img src="upload/no-image.png" alt="Không có ảnh" width="50">';
    }
    ?>
</td>

                <td>
                    <a href="detail.php?MaSV=<?= $row['MaSV'] ?>" class="btn btn-green">Xem</a>
                    <a href="edit.php?MaSV=<?= $row['MaSV'] ?>" class="btn btn-yellow">Sửa</a>
                    <a href="delete.php?MaSV=<?= $row['MaSV'] ?>" class="btn btn-red" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
