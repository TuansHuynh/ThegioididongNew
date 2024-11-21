<?php
$serverName = "HUYNH-ANH-TUAN\TUANSHUYNH"; // hoặc "127.0.0.1", hoặc tên server của bạn
$connectionInfo = array(
    "Database" => "Thegioididong_admin",  // Tên cơ sở dữ liệu
    "UID" => "sa",     // Tài khoản SQL Server
    "PWD" => "123"      // Mật khẩu
);

// Kết nối
$conn = sqlsrv_connect($serverName, $connectionInfo);

// Kiểm tra kết nối
if ($conn) {
    echo "Kết nối thành công!";
} else {
    echo "Kết nối thất bại: " . print_r(sqlsrv_errors(), true);
}

// Đóng kết nối
sqlsrv_close($conn);
?>