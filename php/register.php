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

// Xử lý dữ liệu từ form đăng ký
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Kiểm tra username hoặc email đã tồn tại chưa
    $checkSql = "SELECT * FROM Users WHERE Username = ? OR Email = ?";
    $checkParams = [$username, $email];
    $checkStmt = sqlsrv_query($conn, $checkSql, $checkParams);

    if ($checkStmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_has_rows($checkStmt)) {
        // Username hoặc Email đã tồn tại
        echo "<script>alert('Username hoặc Email đã tồn tại!');</script>";
        echo "<script>window.history.back();</script>";
    } else {
        // Thêm người dùng mới vào cơ sở dữ liệu
        $insertSql = "INSERT INTO Users (Username, Email, Password) VALUES (?, ?, ?)";
        $insertParams = [$username, $email, $password];
        $insertStmt = sqlsrv_query($conn, $insertSql, $insertParams);

        if ($insertStmt === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            echo "<script>alert('Đăng ký thành công!');</script>";
            echo "<script>window.location.href = '../index.html';</script>";
        }
    }

    sqlsrv_free_stmt($checkStmt);
    sqlsrv_free_stmt($insertStmt);
    sqlsrv_close($conn);
}
?>