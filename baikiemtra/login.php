<?php
session_start();

// Nếu đã đăng nhập, chuyển hướng về trang chính
if (isset($_SESSION['maSV'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['submit'])) {
    include 'db_connect.php';

    $maSV = $_POST['maSV'];

    try {
        // Kiểm tra xem MaSV có tồn tại trong bảng SINHVIEN không
        $sql_sinhvien = "SELECT * FROM SINHVIEN WHERE MaSV = :MaSV";
        $stmt_sinhvien = $pdo->prepare($sql_sinhvien);
        $stmt_sinhvien->execute([':MaSV' => $maSV]);
        $sinhvien = $stmt_sinhvien->fetch(PDO::FETCH_ASSOC);

        if ($sinhvien) {
            // Đăng nhập thành công, lưu MaSV vào session
            $_SESSION['maSV'] = $maSV;
            header("Location: index.php");
            exit();
        } else {
            $error = "Mã sinh viên không tồn tại!";
        }
    } catch (PDOException $e) {
        $error = "Lỗi truy vấn: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
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
        .form-group input {
            width: 300px;
            padding: 6px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 14px;
        }
        .btn-login {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-login:hover {
            background-color: #0056b3;
        }
        .error {
            color: #dc3545;
            margin-bottom: 10px;
        }
        .info {
            color: #007bff;
            margin-bottom: 10px;
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
                        <a class="nav-link active" href="login.php">Đăng Nhập</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <h1>ĐĂNG NHẬP</h1>
        <div class="info">Vui lòng nhập mã số sinh viên để đăng nhập.</div>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="maSV">Mã Sinh Viên:</label>
                <input type="text" name="maSV" id="maSV" value="<?php echo isset($maSV) ? htmlspecialchars($maSV) : ''; ?>" required>
            </div>

            <button type="submit" name="submit" class="btn-login">Đăng Nhập</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>