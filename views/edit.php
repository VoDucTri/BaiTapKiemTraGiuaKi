<?php
include '../config/database.php';

if (isset($_GET['MaSV'])) {
    $MaSV = $_GET['MaSV'];
    $sql = "SELECT * FROM SinhVien WHERE MaSV='$MaSV'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newMaSV = $_POST['MaSV'];
    $HoTen = $_POST['HoTen'];
    $GioiTinh = $_POST['GioiTinh'];
    $NgaySinh = $_POST['NgaySinh'];
    $MaNganh = $_POST['MaNganh'];

    $check_sql = "SELECT MaSV FROM SinhVien WHERE MaSV='$newMaSV' AND MaSV != '$MaSV'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo "<p class='error'>Mã sinh viên đã tồn tại! Vui lòng nhập mã khác.</p>";
        exit();
    }

    $upload_dir = "../upload/images/";
    $Hinh = $row['Hinh']; 

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true); 
    }

    if (!empty($_FILES["Hinh"]["name"])) {
        $file_name = uniqid() . "_" . basename($_FILES["Hinh"]["name"]);
        $target_file = $upload_dir . $file_name;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = array("jpg", "jpeg", "png", "gif");

        if (in_array($file_type, $allowed_types)) {
            if (move_uploaded_file($_FILES["Hinh"]["tmp_name"], $target_file)) {

                if ($Hinh != "no-image.png" && file_exists($upload_dir . $Hinh)) {
                    unlink($upload_dir . $Hinh);
                }
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

    $sql = "UPDATE SinhVien SET MaSV='$newMaSV', HoTen='$HoTen', GioiTinh='$GioiTinh', NgaySinh='$NgaySinh', Hinh='$Hinh', MaNganh='$MaNganh' WHERE MaSV='$MaSV'";
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
        .error {
            color: red;
            font-weight: bold;
        }
        img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Sửa Sinh Viên</h2>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Mã SV:</label>
                <input type="text" name="MaSV" value="<?= htmlspecialchars($row['MaSV']) ?>" required>
            </div>
            <div class="form-group">
                <label>Họ Tên:</label>
                <input type="text" name="HoTen" value="<?= htmlspecialchars($row['HoTen']) ?>" required>
            </div>
            <div class="form-group">
                <label>Giới Tính:</label>
                <input type="text" name="GioiTinh" value="<?= htmlspecialchars($row['GioiTinh']) ?>" required>
            </div>
            <div class="form-group">
                <label>Ngày Sinh:</label>
                <input type="date" name="NgaySinh" value="<?= htmlspecialchars($row['NgaySinh']) ?>" required>
            </div>
            <div class="form-group">
                <label>Ảnh Hiện Tại:</label><br>
                <?php
                $image_path = "../upload/images/" . htmlspecialchars($row['Hinh']);
                if (!empty($row['Hinh']) && file_exists($image_path)) {
                    echo '<img src="' . $image_path . '" alt="Hình sinh viên">';
                } else {
                    echo '<p class="text-muted">Không có ảnh</p>';
                }
                ?>
            </div>
            <div class="form-group">
                <label>Upload Ảnh Mới:</label>
                <input type="file" name="Hinh" accept="image/*">
            </div>
            <div class="form-group">
                <label>Mã Ngành:</label>
                <input type="text" name="MaNganh" value="<?= htmlspecialchars($row['MaNganh']) ?>" required>
            </div>
            <button type="submit" class="btn">Cập nhật</button>
        </form>
        <a href="index.php" class="back-btn">Quay lại danh sách</a>
    </div>
</body>
</html>