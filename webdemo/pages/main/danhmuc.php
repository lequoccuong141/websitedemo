<?php
      $sql_pro = "SELECT * FROM  tbl_danhmuc,tbl_sanpham WHERE tbl_sanpham.id_danhmuc=tbl_danhmuc.id_danhmuc
      AND tbl_sanpham.id_danhmuc='$_GET[id]' ORDER BY  tbl_sanpham.id_sanpham  DESC ";
      $query_pro = mysqli_query($mysqli,$sql_pro);
      
      // Get category name separately
      $sql_category = "SELECT tendanhmuc FROM tbl_danhmuc WHERE id_danhmuc='$_GET[id]' LIMIT 1";
      $query_category = mysqli_query($mysqli,$sql_category);
      $row_category = mysqli_fetch_array($query_category);
?>
<h3>Danh mục sản phẩm: <?php echo $row_category['tendanhmuc'] ?></h3>
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

      
