<?php
include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $MaSV = $_POST['MaSV'];
    $HoTen = $_POST['HoTen'];
    $GioiTinh = $_POST['GioiTinh'];
    $NgaySinh = $_POST['NgaySinh'];
    $MaNganh = $_POST['MaNganh'];

    $check_sql = "SELECT MaSV FROM SinhVien WHERE MaSV = '$MaSV'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo "<p class='error'>Mã sinh viên đã tồn tại! Vui lòng nhập mã khác.</p>";
        exit();
    }

    $upload_dir = "../upload/images/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $Hinh = "no-image.png"; 
    if (!empty($_FILES["Hinh"]["name"])) {
        $file_name = uniqid() . "_" . basename($_FILES["Hinh"]["name"]); 
        $target_file = $upload_dir . $file_name;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = array("jpg", "jpeg", "png", "gif");

        if (in_array($file_type, $allowed_types)) {
            if (move_uploaded_file($_FILES["Hinh"]["tmp_name"], $target_file)) {
                $Hinh = $file_name; 
            } else {
                echo "<p class='error'>Lỗi khi upload ảnh.</p>";
                exit();
            }
        } else {
            echo "<p class='error'>Chỉ cho phép file JPG, JPEG, PNG, GIF.</p>";
            exit();
        }
    }

    $sql = "INSERT INTO SinhVien (MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh) 
            VALUES ('$MaSV', '$HoTen', '$GioiTinh', '$NgaySinh', '$Hinh', '$MaNganh')";

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
    <title>Thêm Sinh Viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin-top: 50px;
        }
        .container {
            width: 400px;
            margin: auto;
            padding: 20px;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            color: #333;
        }
        .form-group {
            text-align: left;
            margin-bottom: 10px;
        }
        .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
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
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .btn:hover {
            background: #218838;
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
        .back-btn:hover {
            background: #0056b3;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Thêm Sinh Viên</h2>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="MaSV">Mã SV:</label>
                <input type="text" id="MaSV" name="MaSV" placeholder="Nhập Mã SV" required>
            </div>
            <div class="form-group">
                <label for="HoTen">Họ Tên:</label>
                <input type="text" id="HoTen" name="HoTen" placeholder="Nhập Họ Tên" required>
            </div>
            <div class="form-group">
                <label for="GioiTinh">Giới Tính:</label>
                <input type="text" id="GioiTinh" name="GioiTinh" placeholder="Nam / Nữ" required>
            </div>
            <div class="form-group">
                <label for="NgaySinh">Ngày Sinh:</label>
                <input type="date" id="NgaySinh" name="NgaySinh" required>
            </div>
            <div class="form-group">
                <label for="Hinh">Ảnh Đại Diện:</label>
                <input type="file" id="Hinh" name="Hinh" accept="image/*">
            </div>
            <div class="form-group">
                <label for="MaNganh">Mã Ngành:</label>
                <input type="text" id="MaNganh" name="MaNganh" placeholder="Nhập Mã Ngành" required>
            </div>
            <button type="submit" class="btn">Thêm</button>
        </form>
        <a href="index.php" class="back-btn">Quay lại danh sách</a>
    </div>
</body>
</html>