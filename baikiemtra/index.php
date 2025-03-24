<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Sinh Viên</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #fff;
            padding-top: 70px; /* Khoảng cách để nội dung không bị che bởi navbar */
        }
        h1 {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .add-student {
            display: block;
            margin-bottom: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .add-student:hover {
            text-decoration: underline;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
        }
        table, th, td {
            border: 1px solid #dee2e6;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .student-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
        .action-links a {
            color: #007bff;
            text-decoration: none;
        }
        .action-links a:hover {
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
                        <a class="nav-link active" href="index.php">Sinh Viên</a>
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
        <h1>TRANG SINH VIÊN</h1>
        <a href="create.php" class="add-student">Add Student</a>
        <table class="table">
            <thead>
                <tr>
                    <th>MaSV</th>
                    <th>HoTen</th>
                    <th>GioiTinh</th>
                    <th>NgaySinh</th>
                    <th>Hinh</th>
                    <th>MaNganh</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'db_connect.php';
                $sql = "SELECT SINHVIEN.*, NGANHHOC.TenNganh 
                        FROM SINHVIEN 
                        JOIN NGANHHOC ON SINHVIEN.MaNganh = NGANHHOC.MaNganh";
                $stmt = $pdo->query($sql);
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['MaSV']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['HoTen']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['GioiTinh']) . "</td>";
                    echo "<td>" . date('m/d/Y h:i:s A', strtotime($row['NgaySinh'])) . "</td>";
                    echo "<td>";
                    if (!empty($row['Hinh']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $row['Hinh'])) {
                        echo "<img src='" . htmlspecialchars($row['Hinh']) . "' alt='Hinh' class='student-image'>";
                    } else {
                        echo "Hình không tồn tại";
                    }
                    echo "</td>";
                    echo "<td>" . htmlspecialchars($row['MaNganh']) . "</td>";
                    echo "<td class='action-links'>
                            <a href='edit.php?id=" . $row['MaSV'] . "'>Edit</a> |
                            <a href='detail.php?id=" . $row['MaSV'] . "'>Details</a> |
                            <a href='delete.php?id=" . $row['MaSV'] . "'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>