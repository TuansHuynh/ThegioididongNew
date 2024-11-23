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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $tenSP = $_POST['TenSP'];
    $giaGoc = $_POST['GiaGoc'];
    $phanTramGiamGia = $_POST['PhanTramGiamGia'];

    // Kiểm tra xem trường tên sản phẩm và giá gốc có hợp lệ không
    if ($tenSP && $giaGoc >= 0) {
        // Xử lý ảnh tải lên
        if (isset($_FILES['Anh']) && $_FILES['Anh']['error'] == 0) {
            $imageTmpPath = $_FILES['Anh']['tmp_name'];
            $imageName = $_FILES['Anh']['name'];
            $imageExtension = pathinfo($imageName, PATHINFO_EXTENSION);

            // Kiểm tra định dạng ảnh (có thể thêm kiểm tra loại ảnh ở đây)
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array(strtolower($imageExtension), $allowedExtensions)) {
                // Tạo đường dẫn lưu trữ ảnh
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);  // Tạo thư mục nếu chưa có
                }
                $newImageName = uniqid() . '.' . $imageExtension;
                $uploadPath = $uploadDir . $newImageName;

                // Di chuyển ảnh vào thư mục uploads
                if (move_uploaded_file($imageTmpPath, $uploadPath)) {
                    // Chuẩn bị câu truy vấn SQL để thêm sản phẩm vào cơ sở dữ liệu
                    $sql = "INSERT INTO SanPham (TenSP, GiaGoc, PhanTramGiamGia, Anh) 
                            VALUES (?, ?, ?, ?)";
                    $params = array($tenSP, $giaGoc, $phanTramGiamGia, $uploadPath);
                    $stmt = sqlsrv_query($conn, $sql, $params);

                    if ($stmt === false) {
                        die(print_r(sqlsrv_errors(), true));
                    } else {
                        echo "<p>Product added successfully!</p>";
                    }
                } else {
                    echo "<p>Failed to upload image.</p>";
                }
            } else {
                echo "<p>Invalid image format. Only jpg, jpeg, png, gif are allowed.</p>";
            }
        } else {
            echo "<p>Please upload an image.</p>";
        }
    } else {
        echo "<p>Invalid input. Please check your data.</p>";
    }
}

// Đóng kết nối
sqlsrv_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="./add.php">
</head>
<body>
    <div class="add-product-form">
        <h2>Add New Product</h2>
        <form action="add_product.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="TenSP">Product Name:</label>
                <input type="text" id="TenSP" name="TenSP" required>
            </div>
            <div class="form-group">
                <label for="GiaGoc">Original Price:</label>
                <input type="number" id="GiaGoc" name="GiaGoc" required>
            </div>
            <div class="form-group">
                <label for="PhanTramGiamGia">Discount Percentage:</label>
                <input type="number" id="PhanTramGiamGia" name="PhanTramGiamGia" min="0" max="100">
            </div>
            <div class="form-group">
                <label for="Anh">Product Image:</label>
                <input type="file" id="Anh" name="Anh" accept="image/*" required>
            </div>
            <button type="submit">Add Product</button>
        </form>
        <p><button onclick="window.location.href='./manager_product.php'">Go back to Product Management</button></p>
    </div>
</body>
</html>