<?php
session_start();

// Xác định đường dẫn tuyệt đối tới file config
$config_path = $_SERVER['DOCUMENT_ROOT'] . '/webdemo/admincp/config/config.php';

// Kiểm tra và bao gồm file config
if (file_exists($config_path)) {
    include($config_path);
} else {
    die("Lỗi: Không tìm thấy file cấu hình tại $config_path!");
}

// Kiểm tra nếu có ID sản phẩm
if (isset($_GET['id'])) {
    $id_sanpham = intval($_GET['id']); // Ép kiểu để tránh SQL Injection

    // Truy vấn lấy thông tin sản phẩm theo ID
    $sql_chitiet = "SELECT * FROM tbl_sanpham WHERE id_sanpham = ? LIMIT 1";
    $stmt = mysqli_prepare($mysqli, $sql_chitiet);
    mysqli_stmt_bind_param($stmt, "i", $id_sanpham);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    // Kiểm tra nếu sản phẩm tồn tại
    if ($row) {
        $id = $row['id_sanpham'];
        $masp = $row['masp'];
        $tensanpham = $row['tensanpham'];
        $giasp = $row['giasp'];
        $hinhanh = $row['hinhanh'];

        // Kiểm tra xem giỏ hàng đã tồn tại chưa trong session
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $found = false;

        // Duyệt giỏ hàng, kiểm tra sản phẩm đã tồn tại hay chưa
        foreach ($_SESSION['cart'] as &$cart_item) {
            if ($cart_item['id'] == $id) {
                $cart_item['soluong'] += 1; // Nếu sản phẩm đã có, tăng số lượng
                $found = true;
                break;
            }
        }
        unset($cart_item); // Giải phóng bộ nhớ

        // Nếu sản phẩm chưa có trong giỏ hàng, thêm vào
        if (!$found) {
            $_SESSION['cart'][] = array(
                'id' => $id,
                'masp' => $masp,
                'tensanpham' => $tensanpham,
                'giasp' => $giasp,
                'hinhanh' => $hinhanh,
                'soluong' => 1
            );
        }

        // Chuyển hướng đến trang giỏ hàng
        header('Location: ../../index.php?quanly=giohang');
        exit();
    } else {
        $_SESSION['message'] = "❌ Sản phẩm không tồn tại!";
        header('Location: ../../index.php?quanly=giohang');
        exit();
    }
}

// Hiển thị thông báo nếu có
if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-info">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']); // Xóa thông báo sau khi hiển thị
}
?>
