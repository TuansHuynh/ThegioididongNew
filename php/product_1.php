<?php
// Kết nối cơ sở dữ liệu
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

// Truy vấn lấy danh sách sản phẩm
$sql = "SELECT MaSP, TenSP, GiaGoc, Anh FROM SanPham";
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Đọc danh sách sản phẩm vào mảng
$products = [];
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $products[] = $row;
}

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thegioididong - Trang chủ</title>
    <link rel="icon" href="../Image/logo-icon.jpg">
    <link rel="stylesheet" href="../assets/css/Style.css">
    <link rel="stylesheet" href="../assets/css/Order.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <nav>
        <a href="index.html"><img class="header_banner" src="../Image/banner.jpg"></a>
    </nav>
<!--------------------------------Header----------------------------->
<header>
    <nav>
        <div class="menu_1">
            <a href="index.html"><img class="nav_logo" src="../Image/logo_tgdd.jpg"></a>
            <ul class="header_menu_1">
                <li id="address" class="menu_li_1">Chọn địa chỉ<i class='bx bx-caret-down'></i></li>
                <li class="menu_li_2"><input type="text" placeholder="Bạn cần tìm gì ?"><i class='bx bx-search'></i></li>
                <li class="menu_li_4"><a href="../cart.html">Tài Khoản <br> & Đơn Hàng</a></li>
                <li id="cart" class="menu_li_3"><a class="cart" href="#"><i class='bx bx-cart-alt'></i>Giỏ Hàng</a></li>
                <li class="menu_li_5"><a href="../24hTech.html">24h <br> Công Nghệ</a></li>
                <li class="menu_li_6 drawer hline"><a href="../q&a.html">Hỏi Đáp</a></li>
                <li class="menu_li_7 drawer hline"><a href="../login.php">Đăng Nhập</a></li>
            </ul>
<!--------------------------------Cart----------------------------->
            <div class="order" id="order">
                <h2>Sản phẩm đã đặt hàng</h2>
                <div class="close">
                    <p id="close">X Đóng</p>
                </div>
                <div class="order_container">
                    <div class="order_list">
                        <form action="">
                            <table>
                                <thead>
                                    <tr>
                                        <th >Sản phẩm</th>
                                        <th >Giá gốc</th>
                                        <th >Số lượng</th>
                                        <th >Chọn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </form>
                        <div class="price-total">
                            <p>Tổng tiền: <span>0</span><sup>đ</sup></p>
                        </div>
                    </div>
                </div>
            </div>
<!--------------------------------Address----------------------------->
            <div class="address-container">
                <div class="address-content">
                    <h2>Chọn địa chỉ nhận hàng<span id="adress-close">X Đóng</span></h2>
                    <form action="">
                        <select id="city" name="">
                            <option value="" selected>Chọn tỉnh thành</option>
                        </select>

                        <select id="district" name="">
                            <option value="" selected>Chọn quận huyện</option>
                        </select>

                        <select id="ward" name="">
                            <option value="" selected>Chọn phường xã</option>
                        </select>

                        <input type="text" placeholder="Số nhà, tên đường">
                        <button type='button' id="location-confirm">Xác nhận</button>
                    </form>
                </div>
            </div>
        </div>
<!--------------------------------Header----------------------------->
        <div class="menu_2">
            <ul class="header_menu_2">
                <li><a href="../phone.html"><img src="../Image/Icon/phonne.png">Điện thoại</a></li>
                <li><a href="../laptop.html"><img src="../Image/Icon/laptop.png">Laptop</a></li>
                <li><a href="../tablet.html"><img src="../Image/Icon/tablet.png">Tablet</a></li>
                <li class="menu_2_li"><a href="#"><img src="../Image/Icon/phu-kien.png">Phụ kiện<i class='bx bx-caret-down'></i></a>
                    <div class="phu-kien">
                        <div class="phu-kien_container">
                            <ul>
                                <li class="phu-kien_li"><span>Phụ kiện di động</span></li>
                                <li><a href="">Sạc dự phòng</a></li>
                                <li><a href="">Sạc, cáp</a></li>
                                <li><a href="">Hub, cáp chuyển đổi</a></li>
                                <li><a href="">Ốp lưng điện thoại</a></li>
                                <li><a href="">Ốp lưng máy tính bảng</a></li>
                            </ul>
                            
                            <ul>
                                <li class="phu-kien_li"><span>Thiết bị âm thanh</span></li>
                                <li><a href="">Tai nghe Bluetooth</a></li>
                                <li><a href="">Tai nghe dây</a></li>
                                <li><a href="">Tai nghe chụp tai</a></li>
                                <li><a href="">Tai nghe truyền xương</a></li>
                                <li><a href="">Loa</a></li>
                                <li><a href="">Micro</a></li>
                            </ul>
                            
                            <ul>
                                <li class="phu-kien_li"><span>Phụ kiện laptop</span></li>
                                <li><a href="">Chuột máy tính</a></li>
                                <li><a href="">Bàn phím</a></li>
                                <li><a href="">Router - Thiết bị mạng</a></li>
                                <li><a href="">Balo, túi chống sốc</a></li>
                            </ul>
                            
                            <ul>
                                <li class="phu-kien_li"><span>Thiết bị nhà thông minh</span></li>
                                <li><a href="">Camera trong nhà</a></li>
                                <li><a href="">Camera ngoài trời</a></li>
                            </ul>
                            
                            <ul>
                                <li class="phu-kien_li"><span>Thiết bị lưu trữ</span></li>
                                <li><a href="">Ổ cứng di động</a></li>
                                <li><a href="">Thẻ nhớ</a></li>
                                <li><a href="">Usb</a></li>
                            </ul>
                            
                            <ul>
                                <li class="phu-kien_li"><span>Thương hiệu hàng đầu</span></li>
                                <li><a href="">Apple</a></li>
                                <li><a href="">Samsung</a></li>
                                <li><a href="">Dell</a></li>
                                <li><a href="">Asus</a></li>
                                <li><a href="">MSI</a></li>
                                <li><a href="">Acer</a></li>
                                <li><a href="">HP</a></li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li><a href="#"><img src="../Image/Icon/smartwatch.png">Smartwatch</a></li>
                <li><a href="#"><img src="../Image/Icon/watch.png">Đồng hồ</a></li>
                <li><a href="#"><img src="../Image/Icon/may-cu.png">Thu cũ đổi mới</a></li>
                <li><a href="#"><img src="../Image/Icon/PC.png">PC, Máy in</a></li>
                <li><a href="#"><img src="../Image/Icon/sim.png">Sim, Thẻ cào</a></li>
                <li><a href="#"><img src="../Image/Icon/tien-ich.png">Dịch vụ tiện ích</a></li>
            </ul>
        </div>
    </nav>
</header>

<body>
    <div class="product-container">
        <header>
            <h1>Our Products</h1>
        </header>
        <main>
            <?php if (!empty($products)) { ?>
                <div class="product-grid">
                    <?php foreach ($products as $product) { ?>
                        <div class="product-card">
                            <img src="/<?php echo $product['Anh']; ?>" alt="Product Image">
                            <h3><?php echo htmlspecialchars($product['TenSP']); ?></h3>
                            <p>Price: <?php echo number_format($product['GiaGoc'], 0, ',', '.'); ?> VND</p>
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <p>No products found.</p>
            <?php } ?>
        </main>
    </div>
</body>

</html>