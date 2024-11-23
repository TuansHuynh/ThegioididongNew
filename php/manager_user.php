<?php
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

// Truy vấn lấy danh sách người dùng
$sql = "SELECT  id, username, user_role FROM Users"; // Thay 'role' bằng 'user_role' nếu tên cột là 'user_role'
$query = sqlsrv_query($conn, $sql);

// Kiểm tra nếu có lỗi trong truy vấn
if ($query === false) {
    die(print_r(sqlsrv_errors(), true));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.php">
    <link rel="icon" href="../Image/logo-icon.jpg">
</head>

<body>
    <div class="dashboard">
        <header>
            <h1>Admin Dashboard</h1>
        </header>
        <nav>
            <ul>
                <li><a href="./manager_user.php">Manage Users</a></li>
                <li><a href="./manager_product.php">Manage Products</a></li> <!-- Liên kết tới trang quản lý sản phẩm -->
                <li><a href="#settings">Settings</a></li>
                <li><a href="/logout">Logout</a></li>
            </ul>
        </nav>
        <main>
            <h2>Welcome, Admin!</h2>
            <p>Here is an overview of your system:</p>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['user_role']; ?></td>
                            <td>
                                <!-- Thêm nút Delete -->
                                <a href="delete_user.php?id=<?php echo $row['id']; ?>" class="btn delete" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </main>
    </div>

    <?php
    // Đóng kết nối
    sqlsrv_close($conn);
    ?>
</body>

</html>