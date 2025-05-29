<?php
    $thongbao = '';
    if(isset($_POST['themdanhmuc'])){
        $tenkhachhang = $_POST['hovaten'];
        $email = $_POST['email'];
        $diachi = $_POST['diachi'];
        $dienthoai = $_POST['dienthoai'];
        $matkhau = md5($_POST['password']);

        // Kiểm tra email đã tồn tại chưa
        $sql_check = "SELECT * FROM tbl_dangky WHERE email='".$email."'";
        $query_check = mysqli_query($mysqli, $sql_check);
        
        if(mysqli_num_rows($query_check) > 0) {
            $thongbao = '<div style="color: red; margin-bottom: 10px;">Email này đã được đăng ký!</div>';
        } else {
            // Thêm vào bảng tbl_dangky
            $sql_them = "INSERT INTO tbl_dangky(tenkhachhang,email,diachi,matkhau,dienthoai) VALUES('".$tenkhachhang."','".$email."','".$diachi."','".$matkhau."','".$dienthoai."')";
            if(mysqli_query($mysqli,$sql_them)) {
                echo '<script>alert("Thêm người dùng thành công!"); window.location.href="../../index.php?action=quanlyuser&query=them";</script>';
                exit();
            } else {
                $thongbao = '<div style="color: red; margin-bottom: 10px;">Có lỗi xảy ra!</div>';
            }
        }
    }
?>
<p>Thêm người dùng mới</p>
<?php if($thongbao != '') echo $thongbao; ?>
<table border="1" width="50%" style="border-collapse: collapse;">
    <form method="POST" action="">
        <tr>
            <td>Họ và tên</td>
            <td><input type="text" name="hovaten" required></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="email" name="email" required></td>
        </tr>
        <tr>
            <td>Địa chỉ</td>
            <td><input type="text" name="diachi" required></td>
        </tr>
        <tr>
            <td>Số điện thoại</td>
            <td><input type="text" name="dienthoai" required></td>
        </tr>
        <tr>
            <td>Mật khẩu</td>
            <td><input type="password" name="password" required></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" name="themdanhmuc" value="Thêm người dùng"></td>
        </tr>
    </form>
</table>