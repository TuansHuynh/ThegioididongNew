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

// Truy vấn để lấy danh sách sản phẩm
$sqlProduct = "SELECT MaSP, TenSP FROM SanPham";
$stmtProduct = sqlsrv_query($conn, $sqlProduct);

// Lấy thông tin sản phẩm nếu có ID sản phẩm
$productId = isset($_GET['product_id']) ? $_GET['product_id'] : null;

$productInfo = null;
if ($productId) {
    // Truy vấn thông tin sản phẩm
    $sqlProductInfo = "SELECT * FROM SanPham WHERE MaSP = ?";
    $paramsProduct = [$productId];
    $stmtProductInfo = sqlsrv_query($conn, $sqlProductInfo, $paramsProduct);
    if ($stmtProductInfo && sqlsrv_has_rows($stmtProductInfo)) {
        $productInfo = sqlsrv_fetch_array($stmtProductInfo, SQLSRV_FETCH_ASSOC);
    }
}

// Xử lý cập nhật thông tin sản phẩm sau khi form được submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['product_name'];
    $productPrice = $_POST['product_price'];
    $productImage = $_FILES['product_image'];

    // Xử lý hình ảnh nếu có
    if ($productImage['name']) {
        // Lưu hình ảnh vào thư mục
        $targetDir = "uploads/"; // Đảm bảo thư mục này tồn tại
        $targetFile = $targetDir . basename($productImage["name"]);
        move_uploaded_file($productImage["tmp_name"], $targetFile);
        $imagePath = $targetFile;
    } else {
        // Nếu không có hình ảnh mới, giữ nguyên hình ảnh cũ
        $imagePath = $productInfo['Anh']; // Giả sử trường 'HinhAnh' lưu đường dẫn hình ảnh
    }

    // Cập nhật thông tin sản phẩm trong cơ sở dữ liệu
    $sqlUpdate = "UPDATE SanPham SET TenSP = ?, GiaGoc = ?, Anh = ? WHERE MaSP = ?";
    $paramsUpdate = [$productName, $productPrice, $imagePath, $productId];
    $stmtUpdate = sqlsrv_query($conn, $sqlUpdate, $paramsUpdate);

    if ($stmtUpdate === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        // Thay đổi thông báo thành alert
        echo "<script>alert('Product updated successfully!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product Information</title>
    <link rel="stylesheet" href="setting.css">
    <link rel="stylesheet" href="edit_product.css">
    <link rel="icon" href="../Image/logo-icon.jpg">
    <script>
        function updateProductInfo() {
            var productId = document.getElementById("select_product").value;
            var url = window.location.href.split('?')[0] + '?product_id=' + productId;
            history.pushState(null, null, url);
            location.reload();
        }
    </script>
</head>

<body>
    <div class="dashboard">
        <header>
            <h1 style="color: #ffff;">Update Product Information</h1>
        </header>
        <nav>
            <ul>
                <li><a href="./manager_user.php">Manage Users</a></li>
                <li><a href="./manager_product.php">Manage Products</a></li>
                <li><a href="./settings.php">Settings Account</a></li>
                <li><a href="../index.html">Logout</a></li>
            </ul>
        </nav>
        <main>
            <h2>Update Product Information:</h2>
            <form method="GET">
                <div>
                    <label for="select_product">Select Product:</label>
                    <select name="product_id" id="select_product" onchange="updateProductInfo()">
                        <option value="">Choose a product</option>
                        <?php while ($row = sqlsrv_fetch_array($stmtProduct, SQLSRV_FETCH_ASSOC)) { ?>
                            <option value="<?php echo $row['MaSP']; ?>" <?php echo (isset($productId) && $productId == $row['MaSP']) ? 'selected' : ''; ?>>
                                <?php echo $row['TenSP']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </form>

            <?php if ($productInfo) { ?>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div>
                        <label for="product_name">Product Name:</label>
                        <input type="text" name="product_name" id="product_name" value="<?php echo $productInfo['TenSP']; ?>" required>
                    </div>
                    <div>
                        <label for="product_price">Price:</label>
                        <input type="number" name="product_price" id="product_price" value="<?php echo $productInfo['GiaGoc']; ?>" required>
                    </div>
                    <div>
                        <label for="product_image">Product Image:</label>
                        <input type="file" name="product_image" id="product_image">
                    </div>
                    <div>
                        <button type="submit">Update Product</button>
                    </div>
                </form>
            <?php } else { ?>
                <p style="text-align: center;">Please select a product to edit its information.</p>
            <?php } ?>

            <!-- Nút quay lại -->
            <div style="text-align: center; margin-top: 20px;">
                <a href="./manager_product.php" class="back-button">Back to Product Management</a>
            </div>
        </main>
    </div>
</body>

</html>

<?php
sqlsrv_free_stmt($stmtProduct);
sqlsrv_free_stmt($stmtProductInfo);
sqlsrv_close($conn);
?>