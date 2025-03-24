<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Sinh Viên</title>
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
        .info-group {
            margin-bottom: 15px;
        }
        .info-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .info-group span {
            font-size: 14px;
        }
        .student-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
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
        <h1>THÔNG TIN CHI TIẾT SINH VIÊN</h1>
        <?php
        include 'db_connect.php';
        $id = $_GET['id'];
        $sql = "SELECT SINHVIEN.*, NGANHHOC.TenNganh 
                FROM SINHVIEN 
                JOIN NGANHHOC ON SINHVIEN.MaNganh = NGANHHOC.MaNganh 
                WHERE MaSV = :MaSV";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':MaSV' => $id]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($student) {
        ?>
            <div class="info-group">
                <label>HoTen:</label>
                <span><?php echo htmlspecialchars($student['HoTen']); ?></span>
            </div>

            <div class="info-group">
                <label>GioiTinh:</label>
                <span><?php echo htmlspecialchars($student['GioiTinh']); ?></span>
            </div>

            <div class="info-group">
                <label>NgaySinh:</label>
                <span><?php echo date('m/d/Y h:i:s A', strtotime($student['NgaySinh'])); ?></span>
            </div>

            <div class="info-group">
                <label>Hinh:</label>
                <?php if (!empty($student['Hinh'])): ?>
                    <img src="<?php echo htmlspecialchars($student['Hinh']); ?>" alt="Hinh" class="student-image">
                <?php else: ?>
                    <span>Hình không tồn tại</span>
                <?php endif; ?>
            </div>

            <div class="info-group">
                <label>MaNganh:</label>
                <span><?php echo htmlspecialchars($student['MaNganh']); ?></span>
            </div>

            <a href="index.php" class="back-to-list">Back to List</a>
        <?php
        } else {
            echo "<p class='text-danger'>Sinh viên không tồn tại.</p>";
            echo "<a href='index.php' class='back-to-list'>Back to List</a>";
        }
        ?>
    </div>
</body>
</html>