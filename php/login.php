<?php
// Kết nối với cơ sở dữ liệu
$serverName = "HUYNH-ANH-TUAN\TUANSHUYNH";
$connectionOptions = [
    "Database" => "Thegioididong_admin",
    "UID" => "sa",
    "PWD" => "123"
];

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Lấy dữ liệu từ form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kiểm tra thông tin đăng nhập
    $sql = "SELECT * FROM Users WHERE Username = ? AND Password = ?";
    $params = [$username, $password];

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Nếu tìm thấy user, chuyển hướng đến index.html
    if (sqlsrv_fetch_array($stmt)) {
        // Sử dụng header() để chuyển hướng
        echo "<script>window.location.href = '../Index.html';</script>";
        exit(); // Đảm bảo không có mã PHP nào được thực thi sau header()
    } else {
        // Thông báo nếu thông tin đăng nhập không hợp lệ
        echo "<script>alert('Invalid username or password. Please try again.');</script>";
    }
}
?>