<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh Sửa Sinh Viên</title>
    <!-- Bootstrap CSS (chỉ dùng để định dạng cơ bản, không cần các hiệu ứng phức tạp) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #fff;
        }
        h1 {
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-group input,
        .form-group select {
            width: 300px;
            padding: 6px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 14px;
        }
        .form-group input[type="file"] {
            padding: 3px;
        }
        .current-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-top: 5px;
        }
        .btn-save {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-save:hover {
            background-color: #218838;
        }
        .back-to-list {
            display: block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .back-to-list:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Main Content -->
    <div class="container">
        <h1>HIỆU CHỈNH THÔNG TIN SINH VIÊN</h1>
        <?php
        include 'db_connect.php';
        $id = $_GET['id'];
        $sql = "SELECT * FROM SINHVIEN WHERE MaSV = :MaSV";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':MaSV' => $id]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);
        ?>
        <form action="edit.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="MaSV" value="<?php echo htmlspecialchars($student['MaSV']); ?>">

            <div class="form-group">
                <label for="HoTen">HoTen:</label>
                <input type="text" name="HoTen" id="HoTen" value="<?php echo htmlspecialchars($student['HoTen']); ?>" required>
            </div>

            <div class="form-group">
                <label for="GioiTinh">GioiTinh:</label>
                <select name="GioiTinh" id="GioiTinh" required>
                    <option value="Nam" <?php if ($student['GioiTinh'] == 'Nam') echo 'selected'; ?>>Nam</option>
                    <option value="Nữ" <?php if ($student['GioiTinh'] == 'Nữ') echo 'selected'; ?>>Nữ</option>
                </select>
            </div>

            <div class="form-group">
                <label for="NgaySinh">NgaySinh:</label>
                <input type="datetime-local" name="NgaySinh" id="NgaySinh" value="<?php echo date('Y-m-d\TH:i', strtotime($student['NgaySinh'])); ?>" required>
            </div>

            <div class="form-group">
                <label for="Hinh">Hinh:</label>
                <input type="file" name="Hinh" id="Hinh" accept="image/*">
                <?php if (!empty($student['Hinh'])): ?>
                    <div>
                        <img src="<?php echo htmlspecialchars($student['Hinh']); ?>" alt="Current Image" class="current-image">
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="MaNganh">MaNganh:</label>
                <select name="MaNganh" id="MaNganh" required>
                    <?php
                    $sql = "SELECT * FROM NGANHHOC";
                    $stmt = $pdo->query($sql);
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $selected = ($row['MaNganh'] == $student['MaNganh']) ? 'selected' : '';
                        echo "<option value='" . $row['MaNganh'] . "' $selected>" . $row['MaNganh'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit" name="submit" class="btn-save">Save</button>
            <a href="index.php" class="back-to-list">Back to List</a>
        </form>
    </div>

    <?php
    if (isset($_POST['submit'])) {
        $MaSV = $_POST['MaSV'];
        $HoTen = $_POST['HoTen'];
        $GioiTinh = $_POST['GioiTinh'];
        $NgaySinh = $_POST['NgaySinh'];
        $MaNganh = $_POST['MaNganh'];

        // Xử lý upload hình ảnh nếu có
        $Hinh = $student['Hinh'];
        if (!empty($_FILES["Hinh"]["name"])) {
            $target_dir = "Content/images/";
            $target_file = $target_dir . basename($_FILES["Hinh"]["name"]);
            move_uploaded_file($_FILES["Hinh"]["tmp_name"], $target_file);
            $Hinh = '/' . $target_file;
        }

        $sql = "UPDATE SINHVIEN 
                SET HoTen = :HoTen, GioiTinh = :GioiTinh, NgaySinh = :NgaySinh, Hinh = :Hinh, MaNganh = :MaNganh 
                WHERE MaSV = :MaSV";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':HoTen' => $HoTen,
            ':GioiTinh' => $GioiTinh,
            ':NgaySinh' => $NgaySinh,
            ':Hinh' => $Hinh,
            ':MaNganh' => $MaNganh,
            ':MaSV' => $MaSV
        ]);

        header("Location: index.php");
        exit();
    }
    ?>
</body>
</html>