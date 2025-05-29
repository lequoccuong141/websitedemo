
<div class="admin-card">
  <div class="admin-card-header">
    <h4 class="mb-0">Thêm danh mục sản phẩm</h4>
  </div>
  <div class="admin-card-body">
    <form method="POST" id="formThemDanhMuc">
      <div class="admin-form-group">
        <label for="tendanhmuc" class="form-label">Tên danh mục</label>
        <input type="text" class="admin-form-control" id="tendanhmuc" name="tendanhmuc" required>
      </div>
      <div class="admin-form-group">
        <label for="thutu" class="form-label">Số thứ tự</label>
        <input type="number" class="admin-form-control" id="thutu" name="thutu" required min="1">
      </div>
      <div class="mt-3">
        <button type="submit" class="admin-btn admin-btn-primary" id="submitBtn">
          <i class="fas fa-plus me-2"></i>Thêm danh mục
        </button>
      </div>
    </form>
  </div>
</div>

<link rel="stylesheet" href="css/admin-styles.css">
<script>
$(document).ready(function() {
  $('#formThemDanhMuc').on('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = $(this).find('#submitBtn');
    submitBtn.prop('disabled', true);
    
    const formData = {
      tendanhmuc: $('#tendanhmuc').val(),
      thutu: $('#thutu').val(),
      themdanhmuc: 1
    };
    
    $.ajax({
      url: 'modules/quanlydanhmucsp/xuly.php',
      method: 'POST',
      data: formData,
      success: function(response) {
        try {
          if (typeof response === 'string') {
            response = JSON.parse(response);
          }
          
          if (response.success) {
            Swal.fire({
              title: 'Thành công!',
              text: response.message,
              icon: 'success'
            }).then(() => {
              window.location.reload();
            });
          } else {
            Swal.fire({
              title: 'Lỗi!',
              text: response.message || 'Có lỗi xảy ra khi thêm danh mục',
              icon: 'error'
            });
          }
        } catch (e) {
          console.error('Parse error:', e, response);
          Swal.fire({
            title: 'Lỗi!',
            text: 'Lỗi xử lý phản hồi từ máy chủ',
            icon: 'error'
          });
        }
      },
      error: function(xhr, status, error) {
        console.error('Ajax error:', status, error);
        Swal.fire({
          title: 'Lỗi!',
          text: 'Không thể kết nối với máy chủ',
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