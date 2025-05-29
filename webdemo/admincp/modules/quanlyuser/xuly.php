<?php
include('../../config/config.php');
    
if(isset($_POST['xoanhieu']) && isset($_POST['delete_ids'])) {
    $delete_ids = $_POST['delete_ids'];
    foreach($delete_ids as $id) {
        $sql_xoa = "DELETE FROM tbl_dangky WHERE id_dangky='".$id."'";
        mysqli_query($mysqli,$sql_xoa);
    }
    header('Location:../../index.php?action=quanlyuser&query=them');
} elseif(isset($_POST['themdanhmuc'])) {
    $tenkhachhang = $_POST['tenkhachhang'];
    $email = $_POST['email'];
    $diachi = $_POST['diachi'];
    $dienthoai = $_POST['dienthoai'];
    $sql_them = "INSERT INTO tbl_dangky(tenkhachhang,email,diachi,dienthoai) VALUES('".$tenkhachhang."','".$email."','".$diachi."','".$dienthoai."')";
    $result = mysqli_query($mysqli,$sql_them);
    if($result) {
        echo '<script>alert("Thêm user thành công!");</script>';
    } else {
        echo '<script>alert("Thêm user thất bại!");</script>';
    }
    echo '<script>window.location.href="../../index.php?action=quanlyuser&query=them";</script>';
} elseif(isset($_POST['suadanhmuc'])) {
    $id = $_POST['id_dangky'];
    $tenkhachhang = $_POST['tenkhachhang'];
    $email = $_POST['email'];
    $diachi = $_POST['diachi'];
    $dienthoai = $_POST['dienthoai'];
    $sql_update = "UPDATE tbl_dangky SET tenkhachhang='".$tenkhachhang."',email='".$email."',diachi='".$diachi."',dienthoai='".$dienthoai."' WHERE id_dangky='".$id."'";
    mysqli_query($mysqli,$sql_update);
    header('Location:../../index.php?action=quanlyuser&query=them');
} elseif(isset($_GET['action']) && $_GET['action'] == 'toggle_status') {
    $id = $_GET['idadmin'];
    $current_status = $_GET['status'];
    $new_status = $current_status == 1 ? 0 : 1;
    
    $sql_update = "UPDATE tbl_admin SET admin_status='".$new_status."' WHERE id_admin='".$id."'";
    mysqli_query($mysqli,$sql_update);
    header('Location:../../index.php?action=quanlyuser&query=lietke_login');
} elseif(isset($_GET['action']) && $_GET['action'] == 'phanquyen') {
    $id = $_GET['iduser'];
    // Lấy thông tin user từ bảng tbl_dangky
    $sql_user = "SELECT * FROM tbl_dangky WHERE id_dangky='".$id."' LIMIT 1";
    $query_user = mysqli_query($mysqli, $sql_user);
    $row_user = mysqli_fetch_array($query_user);
    
    if($row_user) {
        // Tạo tài khoản admin mới
        $username = $row_user['tenkhachhang'];
        $password = $row_user['matkhau']; // Mật khẩu đã được mã hóa
        
        // Kiểm tra xem username đã tồn tại trong bảng admin chưa
        $sql_check = "SELECT * FROM tbl_admin WHERE username='".$username."'";
        $query_check = mysqli_query($mysqli, $sql_check);
        
        if(mysqli_num_rows($query_check) == 0) {
            $sql_them_admin = "INSERT INTO tbl_admin(username,password,admin_status) VALUES('".$username."','".$password."',1)";
            mysqli_query($mysqli, $sql_them_admin);
            echo '<script>alert("Đã phân quyền admin thành công!");</script>';
        } else {
            echo '<script>alert("Tài khoản này đã là admin!");</script>';
        }
    }
    echo '<script>window.location.href="../../index.php?action=quanlyuser&query=them";</script>';
} else {
    $id=$_GET['iduser'];
    $sql_xoa = "DELETE FROM tbl_dangky WHERE id_dangky='".$id."'";
    mysqli_query($mysqli,$sql_xoa);
    header('Location:../../index.php?action=quanlyuser&query=them');
}
?>