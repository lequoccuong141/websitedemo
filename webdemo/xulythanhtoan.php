<?php
include($_SERVER['DOCUMENT_ROOT'].'/webdemo/admincp/config/config.php');
session_start();

// Kiểm tra kết nối DB
if (!$mysqli) {
    die("Lỗi kết nối CSDL: " . mysqli_connect_error());
}

// Kiểm tra xem người dùng đã gửi form chưa
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = trim($_POST['fullname']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $notes = trim($_POST['notes']);
    $payment_method = trim($_POST['payment_method']);

    if (empty($fullname) || empty($phone) || empty($email) || empty($address) || empty($payment_method)) {
        $_SESSION['error_message'] = "Vui lòng điền đầy đủ thông tin!";
        header("Location: thanhtoan.php");
        exit();
    }

    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        $_SESSION['error_message'] = "Giỏ hàng của bạn hiện tại trống!";
        header("Location: giohang.php");
        exit();
    }

    // Tính tổng tiền
    $total = 0;
    foreach ($_SESSION['cart'] as $cart_item) {
        if (!isset($cart_item['id']) || !isset($cart_item['soluong']) || !isset($cart_item['giasp'])) {
            die("Lỗi: Dữ liệu giỏ hàng không hợp lệ!");
        }
        $total += $cart_item['giasp'] * $cart_item['soluong'];
    }

    // Lưu đơn hàng vào CSDL
    $sql_order = "INSERT INTO tbl_donhang (fullname, phone, email, address, notes, payment_method, total, date_order) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";

    if (!$stmt = mysqli_prepare($mysqli, $sql_order)) {
        die("Lỗi truy vấn SQL (đơn hàng): " . mysqli_error($mysqli));
    }

    mysqli_stmt_bind_param($stmt, "ssssssd", $fullname, $phone, $email, $address, $notes, $payment_method, $total);
    $result_order = mysqli_stmt_execute($stmt);
    $order_id = mysqli_insert_id($mysqli);
    mysqli_stmt_close($stmt);

    if ($result_order) {
        // Lưu chi tiết đơn hàng
        $sql_detail = "INSERT INTO tbl_chitietdonhang (id_donhang, id_sanpham, soluong, giasp) VALUES (?, ?, ?, ?)";

        if (!$stmt_detail = mysqli_prepare($mysqli, $sql_detail)) {
            die("Lỗi truy vấn SQL (chi tiết đơn hàng): " . mysqli_error($mysqli));
        }

        foreach ($_SESSION['cart'] as $cart_item) {
            mysqli_stmt_bind_param($stmt_detail, "iiid", $order_id, $cart_item['id'], $cart_item['soluong'], $cart_item['giasp']);
            mysqli_stmt_execute($stmt_detail);
        }
        mysqli_stmt_close($stmt_detail);

        // Xóa giỏ hàng sau khi đặt hàng thành công
        unset($_SESSION['cart']);

        $_SESSION['success_message'] = "Đặt hàng thành công! Mã đơn hàng của bạn là: #$order_id";
        header("Location: /webdemo/index.php"); 
        exit();
    } else {
        $_SESSION['error_message'] = "Có lỗi xảy ra khi đặt hàng, vui lòng thử lại!";
        header("Location: thanhtoan.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "Yêu cầu không hợp lệ!";
    header("Location: thanhtoan.php");
    exit();
}
?>
