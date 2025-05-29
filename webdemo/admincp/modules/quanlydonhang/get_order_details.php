<?php
include('../../config/config.php');

// Lấy ID đơn hàng từ request
$id_donhang = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_donhang <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'ID đơn hàng không hợp lệ']);
    exit();
}

// Lấy thông tin đơn hàng
$sql_donhang = "SELECT * FROM tbl_donhang WHERE id_donhang = ?";
$stmt = mysqli_prepare($mysqli, $sql_donhang);
mysqli_stmt_bind_param($stmt, "i", $id_donhang);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$donhang = mysqli_fetch_assoc($result);

if (!$donhang) {
    http_response_code(404);
    echo json_encode(['error' => 'Không tìm thấy đơn hàng']);
    exit();
}

// Lấy chi tiết sản phẩm trong đơn hàng
$sql_chitiet = "SELECT c.*, s.tensanpham 
                FROM tbl_chitietdonhang c 
                JOIN tbl_sanpham s ON c.id_sanpham = s.id_sanpham 
                WHERE c.id_donhang = ?";
$stmt = mysqli_prepare($mysqli, $sql_chitiet);
mysqli_stmt_bind_param($stmt, "i", $id_donhang);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$products = array();
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = array(
        'name' => $row['tensanpham'],
        'quantity' => $row['soluong'],
        'price' => $row['giasp'],
        'total' => $row['soluong'] * $row['giasp']
    );
}

// Chuẩn bị dữ liệu trả về
$response = array(
    'customer_name' => $donhang['fullname'],
    'email' => $donhang['email'],
    'phone' => $donhang['phone'],
    'address' => $donhang['address'],
    'total' => $donhang['total'],
    'products' => $products
);

header('Content-Type: application/json');
echo json_encode($response);