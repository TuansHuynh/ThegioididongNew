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
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $username = $_SESSION['user'];

    // Kiểm tra mật khẩu hiện tại
    $sql = "SELECT password FROM Users WHERE username = ?";
    $params = array($username);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    if ($row['password'] == $currentPassword) {
        // Cập nhật mật khẩu mới
        $sql = "UPDATE Users SET password = ? WHERE username = ?";
        $params = array($newPassword, $username);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conn);

        // Chuyển hướng về trang Settings
        header("Location: settings.php");
        exit();
    } else {
        echo "Mật khẩu hiện tại không đúng.";
    }

    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
}
?>