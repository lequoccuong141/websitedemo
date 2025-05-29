<?php
include('../../config/config.php');

$tensanpham = isset($_POST['tensanpham']) ? $_POST['tensanpham'] : '';
$masp = isset($_POST['masp']) ? $_POST['masp'] : '';
$giasp = isset($_POST['giasp']) ? $_POST['giasp'] : '';
$soluong = isset($_POST['soluong']) ? $_POST['soluong'] : '';

//xuly hinhanh
$hinhanh = isset($_FILES['hinhanh']['name']) ? $_FILES['hinhanh']['name'] : '';
$hinhanh_tmp = isset($_FILES['hinhanh']['tmp_name']) ? $_FILES['hinhanh']['tmp_name'] : '';

$tomtat = isset($_POST['tomtat']) ? $_POST['tomtat'] : '';
$noidung = isset($_POST['noidung']) ? $_POST['noidung'] : '';
$tinhtrang = isset($_POST['tinhtrang']) ? $_POST['tinhtrang'] : '';
$danhmuc = isset($_POST['danhmuc']) ? $_POST['danhmuc'] : '';

if(isset($_POST['themsanpham'])){
      //them
      $sql_them = "INSERT INTO tbl_sanpham(tensanpham,masp,giasp,soluong,hinhanh,tomtat,noidung,tinhtrang,id_danhmuc) VALUE('".$tensanpham."
      ','".$masp."','".$giasp."','".$soluong."','".$hinhanh."','".$tomtat."','".$noidung."','".$tinhtrang."','".$danhmuc."')";
      mysqli_query($mysqli,$sql_them);
      move_uploaded_file($hinhanh_tmp,'uploads/'.$hinhanh);
      header('Location:../../index.php?action=quanlysp&query=them');

}elseif(isset($_POST['suasanpham'])){
      //sua
      if($hinhanh!=''){ 
               

            // Xóa ảnh cũ trước
            $sql = "SELECT * FROM tbl_sanpham WHERE id_sanpham = '$_GET[idsanpham]' LIMIT 1";
            $query = mysqli_query($mysqli,$sql);
            while($row = mysqli_fetch_array($query)){
                  unlink('uploads/'.$row['hinhanh']);
            }

            // Cập nhật dữ liệu với tên file ảnh mới
            $sql_update = "UPDATE tbl_sanpham SET tensanpham='".$tensanpham."', masp='".$masp."',giasp='".$giasp."',
            soluong='".$soluong."',tomtat='".$tomtat."',noidung='".$noidung."',hinhanh='".$hinhanh."',
            tinhtrang='".$tinhtrang."', id_danhmuc='".$danhmuc."' WHERE id_sanpham='$_GET[idsanpham]'";
            
            // Upload ảnh mới
            move_uploaded_file($hinhanh_tmp,'uploads/'.$hinhanh);
      }else{
            // If no new image, update other fields but keep original image
            $sql_update = "UPDATE tbl_sanpham SET tensanpham='".$tensanpham."', masp='".$masp."',giasp='".$giasp."',
            soluong='".$soluong."',tomtat='".$tomtat."',noidung='".$noidung."',
            tinhtrang='".$tinhtrang."' , id_danhmuc='".$danhmuc."' WHERE id_sanpham='$_GET[idsanpham]'";
      }

      mysqli_query($mysqli,$sql_update);
      header('Location:../../index.php?action=quanlysp&query=them');

}else{
      if(!isset($_GET['idsanpham']) || empty($_GET['idsanpham'])) {
            header('Location:../../index.php?action=quanlysp&query=them&message=error&detail='.urlencode('ID sản phẩm không hợp lệ'));
            exit;
      }

      $id = (int)$_GET['idsanpham'];
      
      // Kiểm tra sản phẩm có tồn tại không
      $sql = "SELECT * FROM tbl_sanpham WHERE id_sanpham = ? LIMIT 1";
      $stmt = mysqli_prepare($mysqli, $sql);
      if(!$stmt) {
            header('Location:../../index.php?action=quanlysp&query=them&message=error&detail='.urlencode('Lỗi truy vấn'));
            exit;
      }
      
      mysqli_stmt_bind_param($stmt, "i", $id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      
      if(mysqli_num_rows($result) === 0) {
            header('Location:../../index.php?action=quanlysp&query=them&message=error&detail='.urlencode('Không tìm thấy sản phẩm'));
            exit;
      }
      
      $row = mysqli_fetch_array($result);
      if($row['hinhanh'] && file_exists('uploads/'.$row['hinhanh'])) {
            unlink('uploads/'.$row['hinhanh']);
      }
      
      // Xóa các chi tiết đơn hàng liên quan trước
      $sql_xoa_chitiet = "DELETE FROM tbl_chitietdonhang WHERE id_sanpham = ?";
      $stmt = mysqli_prepare($mysqli, $sql_xoa_chitiet);
      if(!$stmt) {
            header('Location:../../index.php?action=quanlysp&query=them&message=error&detail='.urlencode('Lỗi khi xóa chi tiết đơn hàng'));
            exit;
      }
      mysqli_stmt_bind_param($stmt, "i", $id);
      mysqli_stmt_execute($stmt);
      
      // Thực hiện xóa sản phẩm
      $sql_xoa = "DELETE FROM tbl_sanpham WHERE id_sanpham = ?";
      $stmt = mysqli_prepare($mysqli, $sql_xoa);
      if(!$stmt) {
            header('Location:../../index.php?action=quanlysp&query=them&message=error&detail='.urlencode('Lỗi khi xóa sản phẩm'));
            exit;
      }
      
      mysqli_stmt_bind_param($stmt, "i", $id);
      if(mysqli_stmt_execute($stmt)) {
            header('Location:../../index.php?action=quanlysp&query=them&message=success&detail='.urlencode('Xóa sản phẩm thành công'));
      } else {
            header('Location:../../index.php?action=quanlysp&query=them&message=error&detail='.urlencode('Lỗi khi xóa sản phẩm'));
      }
      exit;

      
}

?>
