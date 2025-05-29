<?php

include('../../admincp/config/config.php');

// Kiểm tra ID sản phẩm có được truyền không
if (isset($_GET['id'])) {
    $id_sanpham = $_GET['id'];

    // Truy vấn lấy thông tin sản phẩm theo ID
    $sql_chitiet = "SELECT * FROM tbl_sanpham WHERE id_sanpham = '$id_sanpham' LIMIT 1";
    $query_chitiet = mysqli_query($mysqli, $sql_chitiet);
    $row = mysqli_fetch_array($query_chitiet);
} else {
    echo "Sản phẩm không tồn tại!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $row['tensanpham']; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        .product-image {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .discount-price {
            font-size: 24px;
            font-weight: bold;
            color: red;
        }
        .old-price {
            font-size: 18px;
            color: #888;
            text-decoration: line-through;
        }
        .btn-buy {
            background-color: red;
            color: white;
            font-size: 18px;
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }
        .btn-buy:hover {
            background-color: darkred;
            color: white;
        }
        .promotion-box {
            background-color: #e8f5e9;
            padding: 15px;
            border-radius: 5px;
            border-left: 5px solid green;
            margin-top: 15px;
        }
        .breadcrumb {
            background: none;
            padding: 8px 0;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    
    <!-- Breadcrumb (Thanh điều hướng) -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../../index.php">Trang Chủ</a></li>
            <li class="breadcrumb-item"><a href="index.php?quanly=sanpham">Sản Phẩm</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $row['tensanpham']; ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- Cột trái: Hình ảnh và thông tin chi tiết -->
        <div class="col-md-6">
            <!-- Hình ảnh sản phẩm -->
            <img src="../../admincp/modules/quanlysp/uploads/<?php echo $row['hinhanh']; ?>" class="product-image mb-4">
            
            <!-- Nội dung chi tiết sản phẩm -->
            <div class="product-content mt-4">
                <h5>Thông tin chi tiết:</h5>
                <div class="content-details">
                    <?php echo $row['noidung']; ?>
                </div>
            </div>
        </div>

        <!-- Cột phải: Thông tin sản phẩm và khuyến mãi -->
        <div class="col-md-6">
            <h2><?php echo $row['tensanpham']; ?></h2>
            <p><strong>Mã sản phẩm:</strong> <?php echo $row['masp']; ?></p>

            <!-- Giá sản phẩm -->
            <p>
                <span class="discount-price">
                    <?php echo number_format((float)$row['giasp'], 0, ',', '.'); ?> VNĐ
                </span>
            </p>

            <p><strong>Số lượng:</strong> <?php echo $row['soluong']; ?></p>
            <p><strong>Tình trạng:</strong> <?php echo ($row['tinhtrang'] == 1) ? 'Còn hàng' : 'Hết hàng'; ?></p>
            
            <!-- Tóm tắt sản phẩm -->
            <div class="product-summary mt-3">
                <h5>Tóm tắt sản phẩm:</h5>
                <p><?php echo $row['tomtat']; ?></p>
            </div>

            <a href="mua-ngay.php?id=<?php echo $row['id_sanpham']; ?>" class="btn btn-buy">MUA TẠI ĐÂY</a>

            <!-- Hộp quà tặng/khuyến mãi -->
            <div class="promotion-box mt-3">
                <h5 class="text-success">🎁 QUÀ TẶNG/KHUYẾN MÃI</h5>
                <ul>
                    <li>✅ Tặng Windows bản quyền theo máy</li>
                    <li>✅ Miễn phí cài màn màu màn hình công nghệ cao</li>
                    <li>✅ Balo thời trang</li>
                    <li>✅ Chuột không dây + Lót chuột cao cấp</li>
                    <li>✅ Tặng gói cài đặt, bảo dưỡng, vệ sinh máy trọn đời</li>
                    <li>✅ Tặng Voucher giảm giá cho lần mua tiếp theo</li>
                </ul>
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
