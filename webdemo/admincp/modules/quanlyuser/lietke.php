<link rel="stylesheet" href="css/user-list.css">
<?php
    $sql_lietke = "SELECT * FROM tbl_dangky ORDER BY id_dangky DESC";
    $query_lietke = mysqli_query($mysqli,$sql_lietke);
?>

<h2 class="page-title">Danh sách người dùng đăng ký</h2>
<form action="modules/quanlyuser/xuly.php" method="post">
<table class="user-table">
    <tr>
        <th><input type="checkbox" id="checkAll" onclick="toggleAll(this)"></th>
        <th>ID</th>
        <th>Tên khách hàng</th>
        <th>Email</th>
        <th>Địa chỉ</th>
        <th>Điện thoại</th>
        <th>Quản lý</th>
    </tr>
    <?php
    while($row = mysqli_fetch_array($query_lietke)){
    ?>
    <tr>
        <td><input type="checkbox" name="delete_ids[]" value="<?php echo $row['id_dangky'] ?>"></td>
        <td><?php echo $row['id_dangky'] ?></td>
        <td><?php echo $row['tenkhachhang'] ?></td>
        <td><?php echo $row['email'] ?></td>
        <td><?php echo $row['diachi'] ?></td>
        <td><?php echo $row['dienthoai'] ?></td>
        <td>
            <div class="action-links">
                <a href="?action=quanlyuser&query=sua&iduser=<?php echo $row['id_dangky'] ?>" class="edit-link">Sửa</a>
                <a href="#" class="delete-button delete-link" data-id="<?php echo $row['id_dangky'] ?>">Xóa</a>
                <a href="modules/quanlyuser/xuly.php?action=phanquyen&iduser=<?php echo $row['id_dangky'] ?>" class="admin-link" onclick="return confirm('Bạn có chắc muốn phân quyền admin cho người dùng này không?')">Phân quyền Admin</a>
            </div>
        </td>
    </tr>
    <?php
    }
    ?>
</table>
<div class="bulk-actions">
    <input type="submit" name="xoanhieu" value="Xóa mục đã chọn" class="bulk-delete" onclick="return confirm('Bạn có chắc muốn xóa các mục đã chọn không?')">
</div>
</form>

<script src="js/user-list.js"></script>
<script>
function toggleAll(source) {
    var checkboxes = document.getElementsByName('delete_ids[]');
    for(var i=0; i<checkboxes.length; i++) {
        checkboxes[i].checked = source.checked;
    }
}
</script>