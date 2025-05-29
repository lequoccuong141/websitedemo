<?php

ob_start();
if (isset($_POST["dangky"])) {
    // Kiểm tra các trường thông tin bắt buộc
    if(empty($_POST['hovaten']) || empty($_POST['email']) || empty($_POST['diachi']) || empty($_POST['dienthoai']) || empty($_POST['matkhau'])) {
        $error_message = '<p style="color: red;">Vui lòng điền đầy đủ thông tin!</p>';
    } else {
        $tenkhachhang = $_POST["hovaten"];
        $email = $_POST["email"];
        $diachi = $_POST["diachi"];
        $dienthoai = $_POST["dienthoai"];
        $matkhau = $_POST["matkhau"];  // Mật khẩu không mã hóa

        // Kiểm tra email đã tồn tại chưa
        $sql_check = "SELECT * FROM tbl_dangky WHERE email='".$email."'";
        $query_check = mysqli_query($mysqli, $sql_check);
        
        if(mysqli_num_rows($query_check) > 0) {
            $error_message = '<p style="color: red;">Email này đã được đăng ký!</p>';
        } else {
            // Thực hiện đăng ký mà không mã hóa mật khẩu
            $sql_dangky = mysqli_query($mysqli ,"INSERT INTO tbl_dangky(tenkhachhang,email,diachi,matkhau,dienthoai) 
            VALUES ('".$tenkhachhang."','".$email."','".$diachi."','".$matkhau."','".$dienthoai."')");

            if($sql_dangky) {
                $_SESSION['dangky'] = $tenkhachhang;
                header('Location: index.php?quanly=giohang');
            } else {
                $error_message = '<p style="color: red;">Lỗi: Không thể đăng ký.</p>';
            }
        }
    }
}
?>

<?php if(isset($error_message)): ?>
    <?php echo $error_message; ?>
<?php endif; ?>
<?php ob_end_flush(); ?>

<p>Đăng ký thành viên</p>
<form action="" method="POST">
    <table border="1" width="50%" style="border-collapse:collapse;">
        <tr>
            <td>Họ và tên</td>
            <td><input type="text" size="50" name="hovaten"></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="text" size="50" name="email"></td>
        </tr>
        <tr>
            <td>Địa chỉ</td>
            <td><input type="text" size="50" name="diachi"></td>
        </tr>
        <tr>
            <td>Số điện thoại</td>
            <td><input type="text" size="50" name="dienthoai"></td>
        </tr>
        <tr>
            <td>Mật khẩu</td>
            <td><input type="password" size="50" name="matkhau"></td>
        </tr>
        <tr>
            <td><input type="submit" name="dangky" value="Đăng ký"></td>
            <td><a href="index.php?quanly=dangnhap">Đăng nhập nếu có tài khoản?</a></td>
        </tr>
    </table>
</form>
