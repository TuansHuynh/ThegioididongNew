<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user'])) {
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

    // Lấy thông tin từ form
    $email = $_POST['email'];
    $role = $_POST['user_role'];
    $username = $_SESSION['user'];

    // Cập nhật thông tin người dùng
    $sql = "UPDATE Users SET email = ?, user_role = ? WHERE username = ?";
    $params = array($email, $role, $username);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);

    // Chuyển hướng về trang Settings
    header("Location: settings.php");
    exit();
}
?>