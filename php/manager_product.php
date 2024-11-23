<?php
// Kết nối cơ sở dữ liệu SQL Server
$serverName = "HUYNH-ANH-TUAN\TUANSHUYNH";  
$connectionOptions = [
    "Database" => "Thegioididong_admin",  
    "UID" => "sa",                        
    "PWD" => "123"                        
]; 

// Kết nối cơ sở dữ liệu
$conn = sqlsrv_connect($serverName, $connectionOptions);

// Kiểm tra kết nối
if ($conn === false) {
    die("Không thể kết nối đến cơ sở dữ liệu: " . print_r(sqlsrv_errors(), true));
}

// Truy vấn danh sách sản phẩm
$sql = "SELECT MaSP, TenSP, GiaGoc, PhanTramGiamGia, GiaSauGiamGia, Anh FROM SanPham";
$result = sqlsrv_query($conn, $sql);

// Kiểm tra truy vấn
if ($result === false) {
    die("Truy vấn không thành công: " . print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <link rel="stylesheet" href="style.php">
    <link rel="icon" href="../Image/logo-icon.jpg">
</head>
<body>
    <div class="dashboard">
        <header>
            <h1>Product Management</h1>
        </header>
        <nav>
            <ul>
                <li><a href="./manager_user.php">Manage Users</a></li>
                <li><a href="./manager_product.php">Manage Products</a></li>
                <li><a href="#settings">Settings</a></li>
                <li><a href="/logout">Logout</a></li>
            </ul>
        </nav>
        <main>
            <a href="./add_product.php" class="btn">Add New Product</a>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Original Price</th>
                        <th>Discount (%)</th>
                        <th>Price After Discount</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (sqlsrv_has_rows($result)): ?>
                        <?php while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)): ?>
                            <tr>
                                <td><?= $row['MaSP'] ?></td>
                                <td><?= htmlspecialchars($row['TenSP']) ?></td>
                                <td><?= number_format($row['GiaGoc'], 2) ?></td>
                                <td><?= $row['PhanTramGiamGia'] ?>%</td>
                                <td><?= number_format($row['GiaSauGiamGia'], 2) ?></td>
                                <td>
                                    <?php if ($row['Anh']): ?>
                                        <img src="<?= $row['Anh'] ?>" alt="Product Image" style="width: 50px; height: auto;">
                                    <?php else: ?>
                                        No Image
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="edit_product.php?id=<?= $row['MaSP'] ?>" class="btn edit">Edit</a>
                                    <!-- Thêm liên kết Delete -->
                                    <a href="./delete_product.php?id=<?= $row['MaSP'] ?>" class="btn delete" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">No products found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>

<?php
// Giải phóng kết quả và đóng kết nối
sqlsrv_free_stmt($result);
sqlsrv_close($conn);
?>