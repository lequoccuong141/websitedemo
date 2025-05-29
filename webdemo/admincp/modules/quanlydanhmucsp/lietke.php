<?php
      $sql_lietke_danhmucsp = "SELECT * FROM tbl_danhmuc ORDER BY thutu ASC";
      $query_lietke_danhmucsp = mysqli_query($mysqli,$sql_lietke_danhmucsp);
?>

<div class="admin-card">
  <div class="admin-card-header">
    <h4 class="mb-0">Danh sách danh mục sản phẩm</h4>
  </div>
  <div class="admin-card-body">
    <div class="table-responsive">
      <table class="admin-table" id="tableDanhMuc">
        <thead>
          <tr>
            <th>Số thứ tự</th>
            <th>Tên danh mục</th>
            <th class="text-center">Thao tác</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while($row = mysqli_fetch_array($query_lietke_danhmucsp)){
          ?>
          <tr>
            <td><?php echo $row['thutu'] ?></td>
            <td><?php echo $row['tendanhmuc'] ?></td>
            <td>
              <div class="admin-action-buttons">
                <a href="?action=quanlydanhmucsanpham&query=sua&iddanhmuc=<?php echo $row['id_danhmuc'] ?>" 
                   class="admin-btn admin-btn-warning">
                   <i class="fas fa-edit"></i>
                </a>
                <button onclick="xoaDanhMuc(<?php echo $row['id_danhmuc'] ?>)" 
                        class="admin-btn admin-btn-danger">
                        <i class="fas fa-trash-alt"></i>
                </button>
              </div>
            </td>
          </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<link rel="stylesheet" href="css/admin-styles.css">
<script>
$(document).ready(function() {
    $('#tableDanhMuc').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Vietnamese.json"
        }
    });
});

function xoaDanhMuc(id) {
    Swal.fire({
        title: 'Xác nhận xóa?',
        text: 'Bạn có chắc chắn muốn xóa danh mục này?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'modules/quanlydanhmucsp/xuly.php',
                method: 'GET',
                data: { iddanhmuc: id },
                success: function(response) {
                    Swal.fire('Đã xóa!', 'Danh mục đã được xóa thành công.', 'success')
                    .then(() => {
                        location.reload();
                    });
                },
                error: function() {
                    Swal.fire('Lỗi!', 'Không thể xóa danh mục.', 'error');
                }
            });
        }
    });
}
</script>