<?php
$serverName = "HUYNH-ANH-TUAN\TUANSHUYNH";
$connectionOptions = [
    "Database" => "Thegioididong_admin",
    "UID" => "sa",
    "PWD" => "123"
];
$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn === false) {
    die("Không thể kết nối cơ sở dữ liệu: " . print_r(sqlsrv_errors(), true));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $tenSP = $_POST['TenSP'];
    $giaGoc = $_POST['GiaGoc'];
    $phanTramGiamGia = $_POST['PhanTramGiamGia'];

    // Kiểm tra dữ liệu đầu vào
    if ($tenSP && is_numeric($giaGoc) && $giaGoc >= 0) {
        // Xử lý ảnh tải lên
        if (isset($_FILES['Anh']) && $_FILES['Anh']['error'] == 0) {
            $imageTmpPath = $_FILES['Anh']['tmp_name'];
            $originalImageName = $_FILES['Anh']['name'];
            $imageExtension = strtolower(pathinfo($originalImageName, PATHINFO_EXTENSION));

            // Kiểm tra định dạng ảnh
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($imageExtension, $allowedExtensions)) {
                // Tạo đường dẫn lưu ảnh
                $uploadDir = 'uploads/'; // Thư mục tương đối
                $uploadAbsolutePath = $_SERVER['DOCUMENT_ROOT'] . '/' . $uploadDir;

                // Tạo thư mục nếu chưa tồn tại
                if (!is_dir($uploadAbsolutePath)) {
                    if (!mkdir($uploadAbsolutePath, 0777, true)) {
                        die("Không thể tạo thư mục lưu ảnh.");
                    }
                }

                // Sử dụng tên ảnh gốc
                $newImageName = $originalImageName;
                $uploadPath = $uploadAbsolutePath . $newImageName;

                // Nếu file trùng lặp, thêm hậu tố vào tên
                $counter = 1;
                while (file_exists($uploadPath)) {
                    $newImageName = pathinfo($originalImageName, PATHINFO_FILENAME) . "_$counter." . $imageExtension;
                    $uploadPath = $uploadAbsolutePath . $newImageName;
                    $counter++;
                }

                // Di chuyển ảnh vào thư mục uploads
                if (move_uploaded_file($imageTmpPath, $uploadPath)) {
                    // Lưu đường dẫn tương đối vào cơ sở dữ liệu
                    $relativePath = $uploadDir . $newImageName;

                    // Thêm sản phẩm vào cơ sở dữ liệu
                    $sql = "INSERT INTO SanPham (TenSP, GiaGoc, PhanTramGiamGia, Anh) 
                            VALUES (?, ?, ?, ?)";
                    $params = array($tenSP, $giaGoc, $phanTramGiamGia, $relativePath);
                    $stmt = sqlsrv_query($conn, $sql, $params);

                    if ($stmt === false) {
                        die("Lỗi thêm sản phẩm: " . print_r(sqlsrv_errors(), true));
                    } else {
                        echo '<p style="text-align: center; margin-top: 20px">Thêm sản phẩm thành công!</p>';
                    }
                } else {
                    echo "<p>Không thể tải ảnh lên. Vui lòng thử lại.</p>";
                }
            } else {
                echo "<p>Định dạng ảnh không hợp lệ. Chỉ hỗ trợ jpg, jpeg, png, gif.</p>";
            }
        } else {
            echo "<p>Vui lòng tải lên một ảnh hợp lệ.</p>";
        }
    } else {
        echo "<p>Thông tin sản phẩm không hợp lệ. Vui lòng kiểm tra lại.</p>";
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
        <p style="text-align: center;"><button onclick="window.location.href='./manager_product.php'" style="width: fit-content;">Go back to Product Management</button></p>
    </div>
</body>
</html>