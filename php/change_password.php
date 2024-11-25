<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];

    // Kiểm tra mật khẩu hiện tại
    $sql = "SELECT password FROM Users WHERE username = ?";
    $params = array($username);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if ($row && $row['password'] === $currentPassword) {
        // Nếu mật khẩu hiện tại khớp, cập nhật mật khẩu mới
        $updateSql = "UPDATE Users SET password = ? WHERE username = ?";
        $updateParams = array($newPassword, $username);
        $updateStmt = sqlsrv_query($conn, $updateSql, $updateParams);

        if ($updateStmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        echo "<script>alert('Password updated successfully.'); window.location.href = 'settings.php';</script>";
    } else {
        echo "<script>alert('Current password is incorrect.'); window.history.back();</script>";
    }

    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
}
?>