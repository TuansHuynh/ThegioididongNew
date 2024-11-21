<?php
$serverName = "HUYNH-ANH-TUAN\\TUANSHUYNH";
$connectionOptions = [
    "Database" => "Thegioididong_admin",
    "UID" => "sa",
    "PWD" => "123"
];

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die("Kết nối thất bại: " . print_r(sqlsrv_errors(), true));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = "SELECT Username FROM Users WHERE Username = ? AND Password = ?";
    $params = [$username, $password];

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die("Lỗi truy vấn SQL: " . print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_has_rows($stmt)) {
        // Đăng nhập thành công
        header("Location: ../index.html");
        exit();
    } else {
        // Sai thông tin đăng nhập
        echo "<script>alert('Sai tên đăng nhập hoặc mật khẩu!');</script>";
        echo "<script>window.history.back();</script>";
    }

    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
}
?>