<?php

// Handle all session and header operations first
if(isset($_POST["dangxuat"]) && $_POST["dangxuat"] == 1){
    unset($_SESSION["dangky"]);
}

if(isset($_GET["dangxuat"]) && $_GET["dangxuat"] == 1){
    unset($_SESSION["dangky"]);
}

// Database queries after session operations
$sql_danhmuc = "SELECT * FROM tbl_danhmuc ORDER BY id_danhmuc DESC";
$query_danhmuc = mysqli_query($mysqli,$sql_danhmuc);
?>
<link rel="stylesheet" href="css/search.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/search.js"></script>

<div class="menu">
                  <div id="search-container">
                      <div class="search-box">
                          <input type="text" id="search-input" placeholder="Tìm kiếm sản phẩm..." autocomplete="off">
                          <i class="fas fa-search search-icon"></i>
                          <div class="search-loader" style="display: none;">
                              <i class="fas fa-spinner fa-spin"></i>
                          </div>
                      </div>
                      <div id="search-results"></div>
                  </div>
                  <ul class="list_menu">
                        <li><a href="index.php">Trang chủ</a></li>
                        <?php
                         while($row_danhmuc = mysqli_fetch_array($query_danhmuc)){
                        ?>

                        <li><a href="index.php?quanly=danhmucsanpham&id=<?php echo $row_danhmuc['id_danhmuc']; ?>"><?php echo $row_danhmuc['tendanhmuc']; ?></a></li>
                        <?php
                        }
                        ?>

                        <li><a href="index.php?quanly=giohang">Giỏ hàng</a></li>
                        <?php 
                        if(isset($_SESSION['dangky'])){
                        ?>
                         <li><a href="index.php?dangxuat=1">Đăng xuất</a></li>
                         <?php 
                        }else{
                              ?>
                              <li><a href="index.php?quanly=dangky">Đăng ký</a></li>
                              <?php
                        }
                        ?>
                        
                        <li><a href="index.php?quanly=tintuc">Tin tức</a></li>
                        <li><a href="index.php?quanly=lienhe">Liên hệ</a></li>
                        
                  </ul>
            </div>