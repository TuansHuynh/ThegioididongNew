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

// Truy vấn để lấy danh sách người dùng
$sql = "SELECT username, email, user_role FROM Users";
$query = sqlsrv_query($conn, $sql);

if ($query === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Lấy danh sách người dùng
$users = [];
while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
    $users[] = $row;
}

// Kiểm tra nếu có người dùng được chọn
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_user'])) {
    $selectedUsername = $_POST['selected_user'];
    // Truy vấn để lấy thông tin người dùng đã chọn
    $sql = "SELECT username, email, user_role FROM Users WHERE username = ?";
    $params = array($selectedUsername);
    $query = sqlsrv_query($conn, $sql, $params);
    $userInfo = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
} else {
    $selectedUsername = '';
    $userInfo = ['username' => '', 'email' => '', 'user_role' => ''];
}

sqlsrv_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings Account</title>
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
                <li><a href="./manager_user.php">Manage Users</a></li>
                <li><a href="./manager_product.php">Manage Products</a></li>
                <li><a href="./settings.php">Settings Account</a></li>
                <li><a href="../index.html">Logout</a></li>
            </ul>
        </nav>
        <main>
            <h2>Select User:</h2>
            <form action="settings.php" method="POST">
                <div>
                    <label for="select_user">Choose a user:</label>
                    <select name="selected_user" id="select_user" required>
                        <option value="">Select a user</option>
                        <?php foreach ($users as $user) { ?>
                            <option value="<?php echo $user['username']; ?>" <?php echo ($selectedUsername == $user['username']) ? 'selected' : ''; ?>>
                                <?php echo $user['username']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <button type="submit">Load User</button>
            </form>

            <?php if (!empty($userInfo['username'])) { ?>
                <h3>Update User Information:</h3>
                <form action="update_settings.php" method="POST">
                    <input type="hidden" name="username" value="<?php echo $userInfo['username']; ?>">
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
                    <button type="submit">Update Info</button>
                </form>

                <h3>Change Password:</h3>
                <form action="change_password.php" method="POST">
                    <input type="hidden" name="username" value="<?php echo $userInfo['username']; ?>">
                    <div>
                        <label for="current_password">Current Password:</label>
                        <input type="password" name="current_password" id="current_password" required>
                    </div>
                    <div>
                        <label for="new_password">New Password:</label>
                        <input type="password" name="new_password" id="new_password" required>
                    </div>
                    <button type="submit">Change Password</button>
                </form>
            <?php } else { ?>
                <p>Please select a user to load their information.</p>
            <?php } ?>
        </main>
    </div>
</body>

</html>