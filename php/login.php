<?php
session_start();

// Xử lý khi người dùng gửi form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kết nối cơ sở dữ liệu SQL Server
    $serverName = "HUYNH-ANH-TUAN\TUANSHUYNH";
    $username = "sa";
    $password = "123";
    $dbName = "Thegioididong_admin";

    // Cấu hình kết nối
    $connectionOptions = [
        "Database" => $dbName,
        "UID" => $username,
        "PWD" => $password
    ];

    // Kết nối với SQL Server
    $conn = sqlsrv_connect($serverName, $connectionOptions);

    if ($conn === false) {
        die(print_r(sqlsrv_errors(), true)); 
    }

    // Lấy thông tin người dùng từ form
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Truy vấn tìm người dùng trong cơ sở dữ liệu
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $params = array($user, $pass);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));  
    }

    if (sqlsrv_has_rows($stmt)) {
        // Lấy thông tin vai trò (role) của người dùng
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $_SESSION['user'] = $user;
        $_SESSION['role'] = $row['user_role']; // Lưu role vào session

        // Kiểm tra quyền và chuyển hướng
        if ($_SESSION['role'] == 'admin') {
            header("Location: ./manager_user.php");  // Nếu là admin, chuyển tới manager_user.php
        }
        else {
            header("Location: ../index.html");  // Nếu là user, chuyển tới trang chủ index.html
        }
        exit();

    } else {
        $_SESSION['error'] = "Sai thông tin đăng nhập.";
    }

    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="page-title">Login Your Account</title>
    <link rel="stylesheet" href="Login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" href="../Image/logo-icon.jpg">
</head>
<body>
    <div class="container">
        <!-- Toggle buttons -->
        <div class="toggle-buttons">
            <button class="toggle-btn active" data-target="login" onclick="changeTitle('Login')">Login</button>
            <button class="toggle-btn" data-target="register" onclick="changeTitle('Register')">Register</button>
        </div>
        
        <!-- Form Đăng Nhập -->
        <div class="form-box login active">
            <form action="" method="POST"> <!-- Chuyển action đến chính trang này -->
                <h1>Login</h1>
                
                <?php
                // Hiển thị thông báo lỗi nếu có
                if (isset($_SESSION['error'])) {
                    echo "<div class='error-message'>" . htmlspecialchars($_SESSION['error']) . "</div>";
                    unset($_SESSION['error']);
                }
                ?>
                
                <div class="input-box">
                    <input type="text" name="username" placeholder="Username" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div class="forgot-link">
                    <a href="#">Forgot password?</a>
                </div>
                <button type="submit" class="btn">Login</button>
                <p>Or login with social platforms</p>
                <div class="social-icons">
                    <a href="#"><i class='bx bxl-google'></i></a>
                    <a href="#"><i class='bx bxl-facebook'></i></a>
                </div>
            </form>
        </div>

        <!-- Form Đăng Ký -->
        <div class="form-box register">
            <form action="register.php" method="POST">
                <h1>Registration</h1>
                <div class="input-box">
                    <input type="text" name="username" placeholder="Username" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="email" name="email" placeholder="Email" required>
                    <i class='bx bxs-envelope'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div class="input-box">
                    <select name="user_role" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="btn">Register</button>
                <p>Or register with social platforms</p>
                <div class="social-icons">
                    <a href="#"><i class='bx bxl-google'></i></a>
                    <a href="#"><i class='bx bxl-facebook'></i></a>
                </div>
            </form>
        </div>
    </div>

    <script src="login.js"></script>
    <script>
        function changeTitle(title) {
            document.getElementById("page-title").innerText = title;
        }
    </script>
</body>
</html>