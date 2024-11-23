<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kết nối cơ sở dữ liệu SQL Server
    $serverName = "HUYNH-ANH-TUAN\TUANSHUYNH";
    $username = "sa";
    $password = "123";
    $dbName = "Thegioididong_admin";

    // Cấu hình kết nối
    $connectionOptions = [
        "Database" => $dbName,
        "UID" => $username,
        "PWD" => $password
    ];

    // Kết nối với SQL Server
    $conn = sqlsrv_connect($serverName, $connectionOptions);

    if ($conn === false) {
        die(print_r(sqlsrv_errors(), true)); 
    }

    // Lấy thông tin người dùng từ form
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Truy vấn tìm người dùng trong cơ sở dữ liệu
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $params = array($user, $pass);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));  
    }

    if (sqlsrv_has_rows($stmt)) {
        // Lấy thông tin vai trò (role) của người dùng
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $_SESSION['user'] = $user;
        $_SESSION['role'] = $row['user_role']; // Lưu role vào session

        // Kiểm tra quyền và chuyển hướng
        if ($_SESSION['role'] == 'admin') {
            header("Location: ./manager_user.php");  // Nếu là admin, chuyển tới manager_user.php
        }
        else {
            header("Location: ../index.html");  // Nếu là user, chuyển tới trang chủ index.html
        }
        exit();

    } else {
        header("Location: ../login.html");  // Nếu không tìm thấy người dùng, quay lại trang login
        exit();
    }

    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
}
?>