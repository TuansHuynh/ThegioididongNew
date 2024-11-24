<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kết nối cơ sở dữ liệu SQL Server
    $serverName = "HUYNH-ANH-TUAN\TUANSHUYNH";  // Tên máy chủ của bạn (SQL Server)
    $username = "sa";          // Tên người dùng cơ sở dữ liệu
    $password = "123";         // Mật khẩu cơ sở dữ liệu
    $dbName = "Thegioididong_admin";  // Tên cơ sở dữ liệu

    // Cấu hình kết nối
    $connectionOptions = [
        "Database" => $dbName,
        "UID" => $username,
        "PWD" => $password
    ];

    // Kết nối với SQL Server
    $conn = sqlsrv_connect($serverName, $connectionOptions);

    if ($conn === false) {
        die(print_r(sqlsrv_errors(), true));  // Nếu kết nối không thành công, hiển thị lỗi
    }

    // Lấy thông tin từ form đăng ký
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $role = $_POST['user_role']; // Lấy thông tin role từ form

    // Bỏ qua kiểm tra trùng tên người dùng và email

    // Thực hiện đăng ký người dùng mới
    $sql = "INSERT INTO users (username, email, password, user_role) VALUES (?, ?, ?, ?)";
    $params = array($user, $email, $pass, $role); // Gửi cả giá trị role vào câu truy vấn

    // Thực thi câu lệnh SQL với tham số
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));  // Nếu có lỗi trong truy vấn
    } else {
        // Sau khi đăng ký thành công, chuyển hướng đến trang login.php
        header("Location: login.php");  
        exit();  // Dừng thực thi script sau khi chuyển hướng
    }

    sqlsrv_free_stmt($stmt);  // Giải phóng bộ nhớ của statement
    sqlsrv_close($conn);  // Đóng kết nối
}
?>