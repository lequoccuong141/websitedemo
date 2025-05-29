<?php
      $sql_pro = "SELECT * FROM  tbl_danhmuc,tbl_sanpham WHERE tbl_sanpham.id_danhmuc=tbl_danhmuc.id_danhmuc 
      ORDER BY  tbl_sanpham.id_sanpham  DESC LIMIT 25";
      $query_pro = mysqli_query($mysqli,$sql_pro);
  
?>

<h3>Sản phẩm</h3>
      <ul class="product_list">
            <?php
            while($row = mysqli_fetch_array($query_pro)){
            ?>

                  <li>
                  <a href="./pages/main/chitiet.php?id=<?php echo $row['id_sanpham'] ?>">

                              <img src="admincp/modules/quanlysp/uploads/<?php echo $row['hinhanh'] ?>">
                              <p class="title_product">Tên sản phẩm: <?php echo $row['tensanpham'] ?></p>
                              <p class="price_product">Giá sản phẩm: <?php echo number_format((float)$row['giasp'],0,',','.').'đ' ?></p>
                              <p><?php echo $row['tendanhmuc'] ?></p>
                    </a>
                  </li>

            <?php
            }
            ?>
      </ul>