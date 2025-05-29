<?php
include('../../../admincp/config/config.php');

// Lấy tham số ngày từ URL
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : null;

// Xây dựng câu truy vấn SQL dựa trên tham số
if ($start_date && $end_date) {
    $sql = "SELECT DATE(date_order) as date, SUM(total) as revenue 
            FROM tbl_donhang 
            WHERE date_order BETWEEN ? AND ? 
            GROUP BY DATE(date_order) 
            ORDER BY date ASC";
    
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $start_date, $end_date);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    // Mặc định lấy dữ liệu 30 ngày gần nhất
    $sql = "SELECT DATE(date_order) as date, SUM(total) as revenue 
            FROM tbl_donhang 
            WHERE date_order >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) 
            GROUP BY DATE(date_order) 
            ORDER BY date ASC";
    
    $result = mysqli_query($mysqli, $sql);
}

$data = array(
    'labels' => array(),
    'values' => array()
);

while ($row = mysqli_fetch_assoc($result)) {
    $data['labels'][] = date('d/m/Y', strtotime($row['date']));
    $data['values'][] = (float)$row['revenue'];
}

header('Content-Type: application/json');
echo json_encode($data);