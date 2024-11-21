<?php
// Kết nối với cơ sở dữ liệu
$serverName = "HUYNH-ANH-TUAN\TUANSHUYNH";
$connectionOptions = [
    "Database" => "Thegioididong_admin",
    "UID" => "sa", // User ID của SQL Server
    "PWD" => "123" // Mật khẩu của SQL Server
];

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Lấy dữ liệu từ form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Thêm user mới vào cơ sở dữ liệu, không kiểm tra trùng lặp
    $sql = "INSERT INTO Users (Username, Email, Password) VALUES (?, ?, ?)";
    $params = [$username, $email, $password]; // Mật khẩu cần mã hóa nếu áp dụng thực tế

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Chuyển hướng sau khi thêm dữ liệu thành công
    echo "<script>window.location.href = '../Index.html';</script>";
}
?>