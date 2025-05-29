<?php
include('../../admincp/config/config.php');

if(isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $keywords = explode(' ', trim($keyword));
    $conditions = array();
    
    // Tạo điều kiện tìm kiếm cho từng từ khóa
    foreach($keywords as $word) {
        if(strlen($word) >= 1) {
            $word = mysqli_real_escape_string($mysqli, $word);
            $conditions[] = "LOWER(tensanpham) LIKE LOWER('%$word%')";
        }
    }
    
    // Kết hợp các điều kiện với OR
    $sql = "SELECT id_sanpham, tensanpham, id_danhmuc, hinhanh, giasp FROM tbl_sanpham";
    if(!empty($conditions)) {
        $sql .= " WHERE " . implode(' OR ', $conditions);
    }
    $sql .= " ORDER BY CASE";
    
    // Ưu tiên kết quả khớp chính xác
    $keyword = mysqli_real_escape_string($mysqli, $keyword);

    $sql .= " WHEN LOWER(tensanpham) = LOWER('$keyword') THEN 1
              WHEN LOWER(tensanpham) LIKE LOWER('$keyword%') THEN 2
              WHEN LOWER(tensanpham) LIKE LOWER('%$keyword%') THEN 3
              ELSE 4 END LIMIT 8";
    
    $query = mysqli_query($mysqli, $sql);
    
    $suggestions = array();
    while($row = mysqli_fetch_array($query)) {
        $suggestions[] = array(
            'id' => $row['id_sanpham'],
            'name' => $row['tensanpham'],
            'category' => $row['id_danhmuc'],
            'image' => $row['hinhanh'],
            'price' => number_format((float)$row['giasp'],0,',','.').'đ'
        );
    }
    
    echo json_encode($suggestions);
}
?>