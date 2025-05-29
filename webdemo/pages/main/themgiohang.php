<?php
session_start();
include('../../admincp/config/config.php');

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Thêm số lượng sản phẩm
if (isset($_GET['cong'])) {
    $id = intval($_GET['cong']);
    foreach ($_SESSION['cart'] as &$cart_item) {
        if ($cart_item['id'] == $id && $cart_item['soluong'] >= 1) {
            $cart_item['soluong'] += 1;
            break;
        }
    }
    unset($cart_item);
    header('Location: ../../index.php?quanly=giohang');
    exit();
}

// Giảm số lượng sản phẩm
if (isset($_GET['tru'])) {
    $id = intval($_GET['tru']);
    foreach ($_SESSION['cart'] as &$cart_item) {
        if ($cart_item['id'] == $id && $cart_item['soluong'] > 1) {
            $cart_item['soluong'] -= 1;
            break;
        }
    }
    unset($cart_item);
    header('Location: ../../index.php?quanly=giohang');
    exit();
}

// Xóa sản phẩm
if (isset($_SESSION['cart']) && isset($_GET['xoa'])) {
    $id = intval($_GET['xoa']);
    $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($cart_item) use ($id) {
        return $cart_item['id'] != $id;
    });
    header('Location: ../../index.php?quanly=giohang');
    exit();
}

// Xóa toàn bộ giỏ hàng
if (isset($_GET['xoatatca']) && $_GET['xoatatca'] == 1) {
    unset($_SESSION['cart']);
    header('Location: ../../index.php?quanly=giohang');
    exit();
}

// Thêm sản phẩm vào giỏ hàng
if (isset($_POST['themgiohang']) && isset($_GET['idsanpham'])) {
    $id = intval($_GET['idsanpham']);
    $soluong = 1;

    // Truy vấn lấy sản phẩm từ database
    $sql = "SELECT * FROM tbl_sanpham WHERE id_sanpham = ? LIMIT 1";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);

    if ($row) {
        $found = false;

        // Duyệt giỏ hàng bằng tham chiếu để đảm bảo cập nhật đúng
        foreach ($_SESSION['cart'] as &$cart_item) {
            if ($cart_item['id'] == $id) {
                $cart_item['soluong'] += 1; // Tăng số lượng nếu đã tồn tại
                $found = true;
                break;
            }
        }
        unset($cart_item); // Giải phóng tham chiếu

        // Nếu sản phẩm chưa có, thêm mới vào giỏ hàng
        if (!$found) {
            $_SESSION['cart'][] = [
                'tensanpham' => $row['tensanpham'],
                'id' => $id,
                'soluong' => $soluong,
                'giasp' => $row['giasp'],
                'hinhanh' => $row['hinhanh'],
                'masp' => $row['masp']
            ];
        }
    }

    mysqli_stmt_close($stmt);

    echo '<pre>';
    print_r($_SESSION['cart']);
    echo '</pre>';
    exit();
}
?>
