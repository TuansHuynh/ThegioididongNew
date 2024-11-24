<?php
session_start();

// Kiểm tra nếu người dùng không phải admin thì chuyển hướng về trang đăng nhập
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}

// Kết nối đến cơ sở dữ liệu
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

// Truy vấn để lấy danh sách người dùng
$sql = "SELECT username, email, user_role FROM Users";
$query = sqlsrv_query($conn, $sql);

if ($query === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Kiểm tra nếu có dữ liệu người dùng
$users = [];
while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
    $users[] = $row;
}

// Kiểm tra nếu có dữ liệu người dùng được chọn
if (isset($_GET['username'])) {
    $selectedUsername = $_GET['username'];
    // Truy vấn để lấy thông tin người dùng đã chọn
    $sql = "SELECT username, email, user_role FROM Users WHERE username = ?";
    $params = array($selectedUsername);
    $query = sqlsrv_query($conn, $sql, $params);
    $userInfo = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
} else {
    // Nếu không có người dùng được chọn, lấy thông tin của người dùng admin hiện tại
    $userInfo = ['username' => '', 'email' => '', 'user_role' => ''];
}

sqlsrv_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="setting.css">
    <link rel="icon" href="../Image/logo-icon.jpg">
</head>

<body>
    <div class="dashboard">
        <header>
            <h1>User Settings</h1>
        </header>
        <nav>
            <ul>
                <li><a href="manager_user.php">Manage Users</a></li>
                <li><a href="manager_product.php">Manage Products</a></li>
                <li><a href="settings.php">Settings</a></li>
                <li><a href="../index.html">Logout</a></li>
            </ul>
        </nav>
        <main>
            <h2>Update User Information:</h2>
            <form action="settings.php" method="GET">
                <div>
                    <label for="select_user">Select User:</label>
                    <select name="username" id="select_user" onchange="this.form.submit()">
                        <option value="">Choose a user</option>
                        <?php foreach ($users as $user) { ?>
                            <option value="<?php echo $user['username']; ?>" <?php echo (isset($selectedUsername) && $selectedUsername == $user['username']) ? 'selected' : ''; ?>>
                                <?php echo $user['username']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </form>

            <?php if (!empty($userInfo['username'])) { ?>
                <form action="update_settings.php" method="POST">
                    <div>
                        <label for="username">Username:</label>
                        <input type="text" name="username" id="username" value="<?php echo $userInfo['username']; ?>" readonly>
                    </div>
                    <div>
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" value="<?php echo $userInfo['email']; ?>" required>
                    </div>
                    <div>
                        <label for="user_role">Role:</label>
                        <select name="user_role" id="user_role">
                            <option value="user" <?php echo ($userInfo['user_role'] == 'user') ? 'selected' : ''; ?>>User</option>
                            <option value="admin" <?php echo ($userInfo['user_role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit">Update Info</button>
                    </div>
                </form>
            <?php } else { ?>
                <p>Please select a user to edit their information.</p>
            <?php } ?>

            <h3>Change Password</h3>
            <form action="change_password.php" method="POST">
                <div>
                    <label for="current_password">Current Password:</label>
                    <input type="password" name="current_password" id="current_password" required>
                </div>
                <div>
                    <label for="new_password">New Password:</label>
                    <input type="password" name="new_password" id="new_password" required>
                </div>
                <div>
                    <button type="submit">Change Password</button>
                </div>
            </form>
        </main>
    </div>
</body>

</html>