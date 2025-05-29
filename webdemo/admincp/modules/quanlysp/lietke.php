<?php
  $sql_lietke_sp = "SELECT s.*, d.tendanhmuc 
                FROM tbl_sanpham s 
                LEFT JOIN tbl_danhmuc d ON s.id_danhmuc = d.id_danhmuc 
                ORDER BY s.id_sanpham DESC";
  $query_lietke_sp = mysqli_query($mysqli,$sql_lietke_sp);
  
  // Create logs directory if it doesn't exist
  $log_dir = dirname(__FILE__) . '/logs';
  if (!file_exists($log_dir)) {
      mkdir($log_dir, 0777, true);
  }
  
  $log_file = $log_dir . '/log.txt';
  $log_message = "User accessed product list page at " . date("Y-m-d H:i:s") . "\n";
  file_put_contents($log_file, $log_message, FILE_APPEND);
?>

<p>Liệt kê danh mục sản phẩm</p>
<table style="width:100%" border="1" style="border-collapse: collapse;">
  <tr>
      <th>Id</th>
      <th>Tên sản phẩm</th>
      <th>Hình ảnh</th>
      <th>Giá sp</th>
      <th>Số lượng</th>
      <th>Danh mục</th>
      <th>Mã sp</th>
      <th>Tóm tắt</th>
      <th>Nội dung</th>
      <th>Trạng thái</th>
      <th>Quản lý</th>
    
  </tr>

  <?php
  $i = 0;
  while($row = mysqli_fetch_array($query_lietke_sp)){
      $i++;
  ?>

  <tr>
      <td><?php echo $i ?></td>
      <td><?php echo $row['tensanpham'] ?></td>
      <td><img src="modules/quanlysp/uploads/<?php echo $row['hinhanh'] ?>" width="150px"></td>
      <td><?php echo $row['giasp'] ?></td>
      <td><?php echo $row['soluong'] ?></td>
      <td><?php echo $row['tendanhmuc'] ?></td>
      <td><?php echo $row['masp'] ?></td>
      <td><?php echo $row['tomtat'] ?></td>
      <td><?php echo $row['noidung'] ?></td>
      <td><?php if($row['tinhtrang']==1){
            echo 'Kích hoạt';
        }else{
            echo 'Ẩn';
        } 
        ?>
      </td>
      <td>
        <a href="modules/quanlysp/xuly.php?idsanpham=<?php echo $row['id_sanpham'] ?>">Xóa</a> | 
        <a href="?action=quanlysp&query=sua&idsanpham=<?php echo $row['id_sanpham'] ?>">Sửa</a>
      </td>
  </tr>

  <?php
  }
  ?>
  
</table>