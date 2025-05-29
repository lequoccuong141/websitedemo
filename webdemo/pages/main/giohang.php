<?php


// Đảm bảo đường dẫn đúng đến file config.php
include($_SERVER['DOCUMENT_ROOT'].'/webdemo/admincp/config/config.php');


?>

<link rel="stylesheet" href="css/cart.css">

<h2>Giỏ hàng</h2>

<?php
if (isset($_SESSION["dangky"])) {
    echo '<p style="font-weight: bold; color: blue; font-size: 18px;">Chào mừng bạn, <span style="color: red;">' . $_SESSION["dangky"] . '</span>! Rất vui khi bạn ghé thăm cửa hàng của chúng tôi. 🎉</p>';
}
?>

<?php
if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    // Giỏ hàng có sản phẩm
?>

<table class="cart-table">
    <tr>
        <th>Id</th>
        <th>Mã sản phẩm</th>
        <th>Tên sản phẩm</th>
        <th>Hình ảnh</th>
        <th>Số lượng</th>
        <th>Giá sản phẩm</th>
        <th>Thành tiền</th>
        <th>Quản lý</th>
    </tr>

    <?php
    $i = 0;
    $tongtien = 0;
    foreach ($_SESSION['cart'] as $cart_item) {
        $thanhtien = $cart_item['soluong'] * floatval($cart_item['giasp']);
        $tongtien += $thanhtien;
        $i++;
    ?>

    <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $cart_item['masp']; ?></td>
        <td><?php echo $cart_item['tensanpham']; ?></td>
        <td><img src="admincp/modules/quanlysp/uploads/<?php echo $cart_item['hinhanh']; ?>" width="100" alt="Product Image"></td>
        <td>
            <div class="quantity-controls">
                <a href="pages/main/themgiohang.php?cong=<?php echo $cart_item['id']; ?>">+</a>
                <span><?php echo $cart_item['soluong']; ?></span>
                <a href="pages/main/themgiohang.php?tru=<?php echo $cart_item['id']; ?>">-</a>
            </div>
        </td>
        <td><?php echo number_format(floatval($cart_item['giasp']), 0, ',', '.') . ' đ'; ?></td>
        <td><?php echo number_format($thanhtien, 0, ',', '.') . ' đ'; ?></td>
        <td><a href="pages/main/themgiohang.php?xoa=<?php echo $cart_item['id']; ?>">Xóa</a></td>
    </tr>

    <?php
    }
    ?>

    <tr>
        <td colspan="8">
            <div class="cart-actions">
                <p class="cart-total">Tổng tiền: <?php echo number_format($tongtien, 0, ',', '.') . ' đ'; ?></p>
                <a href="pages/main/themgiohang.php?xoatatca=1" class="delete-all">Xóa tất cả</a>
            </div>
            <div style="clear: both;"></div>

            <?php 
            if (isset($_SESSION['dangky'])) {
                ?>
                <p style="text-align: center;"><a href="index.php?quanly=thanhtoan">Đặt hàng</a></p>
                <?php
            } else {
                ?>
                <p style="text-align: center;"><a href="index.php?quanly=dangky">Đăng nhập để đặt hàng</a></p>
                <?php
            }
            ?>
        </td>
    </tr>
</table>

<?php
} else {
    // Giỏ hàng trống
    echo "<p>Hiện tại giỏ hàng trống</p>";
}
?>

