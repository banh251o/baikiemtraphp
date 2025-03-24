<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Học Phần</title>
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
        .btn-dangky {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-dangky:hover {
            background-color: #218838;
        }
        .text-danger {
            color: #dc3545;
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
                        <a class="nav-link active" href="hocphan.php">Học Phần</a>
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
        <h1>DANH SÁCH HỌC PHẦN</h1>
        <?php
        session_start();
        if (!isset($_SESSION['maSV'])) {
            echo "<p class='text-danger'>Vui lòng đăng nhập để đăng ký học phần!</p>";
        } else {
            include 'db_connect.php';
            try {
                $sql = "SELECT * FROM HOCPHAN";
                $stmt = $pdo->query($sql);
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($rows) > 0) {
        ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>MaHocPhan</th>
                                <th>TenHocPhan</th>
                                <th>SoTinChi</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($rows as $row) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['MaHocPhan']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['TenHocPhan']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['SoTinChi']) . "</td>";
                                echo "<td>
                                        <a href='dangky.php?maSV=" . $_SESSION['maSV'] . "&maHocPhan=" . $row['MaHocPhan'] . "' class='btn-dangky'>Đăng Ký</a>
                                      </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
        <?php
                } else {
                    echo "<p class='text-danger'>Không có học phần nào để hiển thị.</p>";
                }
            } catch (PDOException $e) {
                echo "<p class='text-danger'>Lỗi truy vấn: " . $e->getMessage() . "</p>";
            }
        }
        ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>