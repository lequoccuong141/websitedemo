<?php
session_start();
$sql_sua_danhmucsp = "SELECT * FROM tbl_danhmuc WHERE id_danhmuc='$_GET[iddanhmuc]' LIMIT 1";
$query_sua_danhmucsp = mysqli_query($mysqli, $sql_sua_danhmucsp);
$row = mysqli_fetch_array($query_sua_danhmucsp);
if(!$row) {
    echo "Không tìm thấy danh mục";
    exit;
}
?>

<div class="admin-card">
    <div class="admin-card-header">
        <h4 class="mb-0">Sửa danh mục sản phẩm</h4>
    </div>
    <div class="admin-card-body">
        <form id="formSuaDanhMuc" method="POST">
            <div class="admin-form-group">
                <label for="tendanhmuc" class="form-label">Tên danh mục</label>
                <input type="text" class="admin-form-control" id="tendanhmuc" name="tendanhmuc" value="<?php echo htmlspecialchars($row['tendanhmuc']); ?>" required>
            </div>
            <div class="admin-form-group">
                <label for="thutu" class="form-label">Thứ tự</label>
                <input type="number" class="admin-form-control" id="thutu" name="thutu" value="<?php echo $row['thutu']; ?>" required min="1">
            </div>
            <div class="mt-3">
                <button type="submit" class="admin-btn admin-btn-primary" id="submitBtn">
                    <i class="fas fa-save me-2"></i>Cập nhật
                </button>
                <a href="index.php?action=quanlydanhmucsanpham&query=them" class="admin-btn admin-btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                </a>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#formSuaDanhMuc').on('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = $(this).find('#submitBtn');
        submitBtn.prop('disabled', true);
        
        const formData = {
            tendanhmuc: $('#tendanhmuc').val(),
            thutu: $('#thutu').val(),
            suadanhmuc: 1
        };
        
        $.ajax({
            url: 'modules/quanlydanhmucsp/xuly.php?iddanhmuc=<?php echo $_GET['iddanhmuc']; ?>',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Thành công!',
                        text: response.message,
                        icon: 'success'
                    }).then(() => {
                        window.location.href = 'index.php?action=quanlydanhmucsanpham&query=them';
                    });
                } else {
                    Swal.fire({
                        title: 'Lỗi!',
                        text: response.message || 'Có lỗi xảy ra khi cập nhật danh mục',
                        icon: 'error'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Ajax error:', status, error);
                console.error('Response:', xhr.responseText);
                Swal.fire({
                    title: 'Lỗi!',
                    text: 'Không thể kết nối với máy chủ hoặc có lỗi xử lý',
                    icon: 'error'
                });
            },
            complete: function() {
                submitBtn.prop('disabled', false);
            }
        });
    });
});
</script>