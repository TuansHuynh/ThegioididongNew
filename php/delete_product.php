<?php
// Đường dẫn tuyệt đối tới thư mục chứa ảnh
$uploadDir = 'C:\Users\nkocn\OneDrive\Desktop\Thegioididong\uploads';

// Kết nối cơ sở dữ liệu SQL Server
$serverName = "HUYNH-ANH-TUAN\TUANSHUYNH";
$connectionOptions = [
    "Database" => "Thegioididong_admin",
    "UID" => "sa",
    "PWD" => "123"
]; 
$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die("Không thể kết nối đến cơ sở dữ liệu: " . print_r(sqlsrv_errors(), true));
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Lấy thông tin file ảnh của sản phẩm từ cơ sở dữ liệu
    $sqlSelect = "SELECT Anh FROM SanPham WHERE MaSP = ?";
    $paramsSelect = array($id);
    $stmtSelect = sqlsrv_query($conn, $sqlSelect, $paramsSelect);

    if ($stmtSelect === false) {
        die("Không thể lấy thông tin sản phẩm: " . print_r(sqlsrv_errors(), true));
    }

    if ($row = sqlsrv_fetch_array($stmtSelect, SQLSRV_FETCH_ASSOC)) {
        $imageFileName = trim($row['Anh']);

        // Đường dẫn đầy đủ của ảnh
        $imagePath = $uploadDir . $imageFileName;
        echo "Debug: Đường dẫn ảnh đầy đủ: $imagePath<br>";

        // Kiểm tra và xóa file ảnh
        if (file_exists($imagePath)) {
            if (unlink($imagePath)) {
                echo "File ảnh đã xóa thành công.<br>";
            } else {
                echo "Lỗi: Không thể xóa file ảnh. Kiểm tra quyền trên thư mục.<br>";
            }
        } else {
            echo "Lỗi: File ảnh không tồn tại tại đường dẫn: $imagePath<br>";
        }

        // Xóa sản phẩm khỏi cơ sở dữ liệu
        $sqlDelete = "DELETE FROM SanPham WHERE MaSP = ?";
        $paramsDelete = array($id);
        $stmtDelete = sqlsrv_query($conn, $sqlDelete, $paramsDelete);

        if ($stmtDelete === false) {
            die("Không thể xóa sản phẩm: " . print_r(sqlsrv_errors(), true));
        }

        // Chuyển hướng về trang quản lý sản phẩm
        header("Location: manager_product.php");
        exit();
    } else {
        echo "Lỗi: Sản phẩm không tồn tại.<br>";
    }
} else {
    echo "Lỗi: Không tìm thấy ID sản phẩm trong URL.<br>";
}

sqlsrv_close($conn);
?>