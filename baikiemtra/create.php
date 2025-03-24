<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sinh Viên</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #fff;
            padding-top: 70px; /* Khoảng cách để nội dung không bị che bởi navbar */
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
        .btn-create {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-create:hover {
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
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">Quản Lý Sinh Viên</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Sinh Viên</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="hocphan.php">Học Phần</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dangky_list.php">Đăng Ký</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Đăng Nhập</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <h1>THÊM SINH VIÊN</h1>
        <form action="create.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="MaSV">MaSV:</label>
                <input type="text" name="MaSV" id="MaSV" required>
            </div>

            <div class="form-group">
                <label for="HoTen">HoTen:</label>
                <input type="text" name="HoTen" id="HoTen" required>
            </div>

            <div class="form-group">
                <label for="GioiTinh">GioiTinh:</label>
                <select name="GioiTinh" id="GioiTinh" required>
                    <option value="Nam">Nam</option>
                    <option value="Nữ">Nữ</option>
                </select>
            </div>

            <div class="form-group">
                <label for="NgaySinh">NgaySinh:</label>
                <input type="datetime-local" name="NgaySinh" id="NgaySinh" required>
            </div>

            <div class="form-group">
                <label for="Hinh">Hinh:</label>
                <input type="file" name="Hinh" id="Hinh" accept="image/*" required>
            </div>

            <div class="form-group">
                <label for="MaNganh">MaNganh:</label>
                <select name="MaNganh" id="MaNganh" required>
                    <?php
                    include 'db_connect.php';
                    $sql = "SELECT * FROM NGANHHOC";
                    $stmt = $pdo->query($sql);
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . $row['MaNganh'] . "'>" . $row['MaNganh'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit" name="submit" class="btn-create">Create</button>
            <a href="index.php" class="back-to-list">Back to List</a>
        </form>
    </div>

    <?php
    if (isset($_POST['submit'])) {
        include 'db_connect.php';

        $MaSV = $_POST['MaSV'];
        $HoTen = $_POST['HoTen'];
        $GioiTinh = $_POST['GioiTinh'];
        $NgaySinh = $_POST['NgaySinh'];
        $MaNganh = $_POST['MaNganh'];

        // Xử lý upload hình ảnh
        $target_dir = "Content/images/";
        $target_file = $target_dir . basename($_FILES["Hinh"]["name"]);
        move_uploaded_file($_FILES["Hinh"]["tmp_name"], $target_file);
        $Hinh = '/' . $target_file;

        $sql = "INSERT INTO SINHVIEN (MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh) 
                VALUES (:MaSV, :HoTen, :GioiTinh, :NgaySinh, :Hinh, :MaNganh)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':MaSV' => $MaSV,
            ':HoTen' => $HoTen,
            ':GioiTinh' => $GioiTinh,
            ':NgaySinh' => $NgaySinh,
            ':Hinh' => $Hinh,
            ':MaNganh' => $MaNganh
        ]);

        header("Location: index.php");
        exit();
    }
    ?>
</body>
</html>