<?php
    $sql_sua = "SELECT * FROM tbl_dangky WHERE id_dangky='".$_GET['iduser']."' LIMIT 1";
    $query_sua = mysqli_query($mysqli,$sql_sua);
    $row = mysqli_fetch_array($query_sua);
?>
<p>Sửa thông tin người dùng</p>
<table border="1" width="50%" style="border-collapse: collapse;">
    <form method="POST" action="modules/quanlyuser/xuly.php">
        <tr>
            <td>Tên khách hàng</td>
            <td><input type="text" name="tenkhachhang" value="<?php echo $row['tenkhachhang'] ?>"></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="email" name="email" value="<?php echo $row['email'] ?>"></td>
        </tr>
        <tr>
            <td>Địa chỉ</td>
            <td><input type="text" name="diachi" value="<?php echo $row['diachi'] ?>"></td>
        </tr>
        <tr>
            <td>Điện thoại</td>
            <td><input type="text" name="dienthoai" value="<?php echo $row['dienthoai'] ?>"></td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="hidden" name="id_dangky" value="<?php echo $row['id_dangky'] ?>">
                <input type="submit" name="suadanhmuc" value="Cập nhật">
            </td>
        </tr>
    </form>
</table>