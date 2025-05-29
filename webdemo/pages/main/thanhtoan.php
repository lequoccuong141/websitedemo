<?php
    include('./admincp/config/config.php');
    
    if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        header('Location: index.php');
        exit;
    }
?>

<div class="container py-5">
    <h2 class="text-center mb-4">Thanh toán đơn hàng</h2>
    
    <div class="row">
        <!-- Thông tin giao hàng -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h4>Thông tin giao hàng</h4>
                </div>
                <div class="card-body">
                    <form action="xulythanhtoan.php" method="POST">
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Họ và tên</label>
                            <input type="text" id="fullname" name="fullname" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="tel" id="phone" name="phone" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ giao hàng</label>
                            <textarea name="address" id="address" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Ghi chú</label>
                            <textarea name="notes" id="notes" class="form-control" rows="2"></textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Phương thức thanh toán</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" value="cod" checked>
                                <label class="form-check-label">Thanh toán khi nhận hàng (COD)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" value="bank_transfer">
                                <label class="form-check-label">Chuyển khoản ngân hàng</label>
                            </div>
                        </div>
                        
                        <button type="submit" name="submit" class="btn btn-success w-100">Đặt hàng</button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Đơn hàng của bạn -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h4>Đơn hàng của bạn</h4>
                </div>
                <div class="card-body">
                    <?php
                        $total = 0;
                        foreach($_SESSION['cart'] as $cart_item) {
                            $id = $cart_item['id'];
                            $sql = "SELECT * FROM tbl_sanpham WHERE id_sanpham = $id";
                            $query = mysqli_query($mysqli, $sql);
                            if(!$query) {
                                echo '<div class="alert alert-danger">Có lỗi xảy ra khi truy vấn dữ liệu</div>';
                                continue;
                            }
                            
                            $row = mysqli_fetch_array($query);
                            if(!$row) {
                                echo '<div class="alert alert-warning">Không tìm thấy thông tin sản phẩm #' . $id . '</div>';
                                continue;
                            }
                            
                            $subtotal = $row['giasp'] * $cart_item['soluong'];
                            $total += $subtotal;
                    ?>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <img src="admincp/modules/quanlysp/uploads/<?php echo $row['hinhanh'] ?>" class="product-thumbnail me-3" alt="<?php echo $row['tensanpham'] ?>" width="50">
                            <div>
                                <h6 class="mb-0"><?php echo $row['tensanpham'] ?></h6>
                                <small class="text-muted">Số lượng: <?php echo $cart_item['soluong'] ?></small>
                                <br>
                                <small class="text-muted">Đơn giá: <?php echo number_format($row['giasp'], 0, ',', '.') ?>đ</small>
                            </div>
                        </div>
                        <span class="text-primary font-weight-bold"><?php echo number_format($subtotal, 0, ',', '.') ?>đ</span>
                    </div>
                    <?php } ?>
                    
                    <hr>
                    <div class="d-flex justify-content-between">
                        <h5>Tổng tiền:</h5>
                        <h5><?php echo number_format($total, 0, ',', '.') ?>đ</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 CSS (cần tải từ CDN hoặc gắn vào trang của bạn nếu chưa có) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .product-thumbnail {
        border-radius: 5px;
    }
    .btn-success {
        padding: 12px;
        font-size: 16px;
        border-radius: 5px;
    }
    .container {
        max-width: 1200px;
        margin-top: 30px;
    }
    .card-header {
        background-color: #f8f9fa;
        font-weight: bold;
    }
</style>
