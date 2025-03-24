<?php
include 'db_connect.php';

// Lấy thông tin từ URL
$maSV = $_GET['maSV'];
$maHocPhan = $_GET['maHocPhan'];

// Xóa bản ghi đăng ký
$sql = "DELETE FROM DANGKY WHERE MaSV = :MaSV AND MaHocPhan = :MaHocPhan";
$stmt = $pdo->prepare($sql);
$stmt->execute([':MaSV' => $maSV, ':MaHocPhan' => $maHocPhan]);

// Chuyển hướng về trang danh sách đăng ký với thông báo
echo "<script>alert('Hủy đăng ký học phần thành công!'); window.location.href='dangky_list.php';</script>";
exit();
?>