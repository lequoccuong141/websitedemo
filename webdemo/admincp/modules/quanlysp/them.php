<div class="admin-card">
  <div class="admin-card-header">
    <h4 class="mb-0">Thêm sản phẩm mới</h4>
  </div>
  <div class="admin-card-body">
    <form method="POST" action="modules/quanlysp/xuly.php" enctype="multipart/form-data" id="formThemSanPham">
      <div class="row">
        <div class="col-md-6">
          <div class="admin-form-group">
            <label for="tensanpham" class="form-label">Tên sản phẩm</label>
            <input type="text" class="admin-form-control" id="tensanpham" name="tensanpham" required>
          </div>

          <div class="admin-form-group">
            <label for="masp" class="form-label">Mã sản phẩm</label>
            <input type="text" class="admin-form-control" id="masp" name="masp" required>
          </div>

          <div class="admin-form-group">
            <label for="giasp" class="form-label">Giá sản phẩm</label>
            <input type="number" class="admin-form-control" id="giasp" name="giasp" required>
          </div>

          <div class="admin-form-group">
            <label for="soluong" class="form-label">Số lượng</label>
            <input type="number" class="admin-form-control" id="soluong" name="soluong" required>
          </div>

          <div class="admin-form-group">
            <label for="danhmuc" class="form-label">Danh mục sản phẩm</label>
            <select class="admin-form-control" id="danhmuc" name="danhmuc" required>
          <?php 
           $sql_danhmuc = "SELECT * FROM  tbl_danhmuc ORDER BY  id_danhmuc  DESC ";
            $query_danhmuc = mysqli_query($mysqli,$sql_danhmuc);
            while($row_danhmuc = mysqli_fetch_array($query_danhmuc)){
            ?>
            <option value="<?php echo $row_danhmuc['id_danhmuc']?>"><?php echo $row_danhmuc['tendanhmuc'] ?> </option>
            <?php
            }
           ?> 
        </select>
          </div>

          <div class="admin-form-group">
            <label for="tinhtrang" class="form-label">Tình trạng</label>
            <select class="admin-form-control" id="tinhtrang" name="tinhtrang">
              <option value="1">Kích hoạt</option>
              <option value="0">Ẩn</option>
            </select>
          </div>
        </div>

        <div class="col-md-6">
          <div class="admin-form-group">
            <label for="hinhanh" class="form-label">Hình ảnh</label>
            <input type="file" class="admin-form-control" id="hinhanh" name="hinhanh" accept="image/*" required>
            <div id="previewImage" class="mt-2"></div>
          </div>

          <div class="admin-form-group">
            <label for="tomtat" class="form-label">Tóm tắt</label>
            <textarea class="admin-form-control" id="tomtat" name="tomtat" rows="4"></textarea>
          </div>

          <div class="admin-form-group">
            <label for="noidung" class="form-label">Nội dung</label>
            <textarea class="admin-form-control" id="noidung" name="noidung" rows="6"></textarea>
          </div>
        </div>
      </div>

      <div class="mt-3">
        <button type="submit" class="admin-btn admin-btn-primary" name="themsanpham">
          <i class="fas fa-plus me-2"></i>Thêm sản phẩm
        </button>
      </div>
    </form>
  </div>
</div>

<link rel="stylesheet" href="css/admin-styles.css">
<script>
$(document).ready(function() {
  // Preview image before upload
  $('#hinhanh').change(function() {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        $('#previewImage').html(`<img src="${e.target.result}" class="admin-img-thumbnail" />`)
      }
      reader.readAsDataURL(file);
    }
  });

  // Initialize WYSIWYG editor
  $('#noidung').summernote({
    height: 200,
    toolbar: [
      ['style', ['style']],
      ['font', ['bold', 'underline', 'clear']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['insert', ['link', 'picture']]
    ]
  });

  // Form submission with AJAX
  $('#formThemSanPham').on('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    $.ajax({
      url: $(this).attr('action'),
      method: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
        Swal.fire({
          title: 'Thành công!',
          text: 'Đã thêm sản phẩm mới',
          icon: 'success'
        }).then(() => {
          location.reload();
        });
      },
      error: function() {
        Swal.fire({
          title: 'Lỗi!',
          text: 'Không thể thêm sản phẩm',
          icon: 'error'
        });
      }
    });
  });
});
</script>