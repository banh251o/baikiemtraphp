<?php
include 'db_connect.php';

// Lấy thông tin từ URL
$maSV = $_GET['maSV'];
$maHocPhan = $_GET['maHocPhan'];

// Kiểm tra xem sinh viên đã đăng ký học phần này chưa
$sql_check = "SELECT * FROM DANGKY WHERE MaSV = :MaSV AND MaHocPhan = :MaHocPhan";
$stmt_check = $pdo->prepare($sql_check);
$stmt_check->execute([':MaSV' => $maSV, ':MaHocPhan' => $maHocPhan]);
$existing = $stmt_check->fetch(PDO::FETCH_ASSOC);

if ($existing) {
    // Nếu đã đăng ký, hiển thị thông báo và chuyển hướng
    echo "<script>alert('Bạn đã đăng ký học phần này rồi!'); window.location.href='hocphan.php';</script>";
    exit();
}

// Thêm bản ghi vào bảng DANGKY
$sql = "INSERT INTO DANGKY (MaSV, MaHocPhan) VALUES (:MaSV, :MaHocPhan)";
$stmt = $pdo->prepare($sql);
$stmt->execute([':MaSV' => $maSV, ':MaHocPhan' => $maHocPhan]);

// Chuyển hướng về trang học phần với thông báo thành công
echo "<script>alert('Đăng ký học phần thành công!'); window.location.href='hocphan.php';</script>";
exit();
?>