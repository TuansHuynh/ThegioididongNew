<?php
$serverName = "HUYNH-ANH-TUAN\TUANSHUYNH";
$connectionOptions = [
    "Database" => "Thegioididong_admin",
    "UID" => "sa",
    "PWD" => "123"
];

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die("Kết nối thất bại: " . print_r(sqlsrv_errors(), true));
} else {
    echo "Kết nối thành công!";
}
?>