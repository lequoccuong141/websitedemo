<?php
include('../admincp/config/config.php');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="css/chitietdonhang.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">
<?php
session_start();

// Kiểm tra kết nối CSDL
if (!$mysqli) {
    die("Lỗi kết nối CSDL: " . mysqli_connect_error());
}

// Lấy ID đơn hàng từ URL
$id_donhang = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_donhang <= 0) {
    die("Lỗi: ID đơn hàng không hợp lệ!");
}

// Truy vấn thông tin đơn hàng
$sql_donhang = "SELECT * FROM tbl_donhang WHERE id_donhang = ?";
$stmt_donhang = mysqli_prepare($mysqli, $sql_donhang);
mysqli_stmt_bind_param($stmt_donhang, "i", $id_donhang);
mysqli_stmt_execute($stmt_donhang);
$result_donhang = mysqli_stmt_get_result($stmt_donhang);
$donhang = mysqli_fetch_assoc($result_donhang);

if (!$donhang) {
    die("Lỗi: Không tìm thấy đơn hàng!");
}

// Truy vấn thông tin chi tiết đơn hàng
$sql_chitiet = "SELECT c.id_donhang, s.tensanpham, c.soluong, c.giasp 
                FROM tbl_chitietdonhang AS c
                JOIN tbl_sanpham AS s ON c.id_sanpham = s.id_sanpham
                WHERE c.id_donhang = ?";

$stmt = mysqli_prepare($mysqli, $sql_chitiet);
if (!$stmt) {
    die("Lỗi truy vấn SQL: " . mysqli_error($mysqli));
}

mysqli_stmt_bind_param($stmt, "i", $id_donhang);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<div class="container-fluid py-4">
    <!-- Thông tin đơn hàng -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Thông tin đơn hàng #<?php echo $id_donhang; ?></h5>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Ngày đặt:</strong></p>
                            <p class="text-muted"><?php echo date('d/m/Y H:i', strtotime($donhang['date_order'])); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Trạng thái đơn hàng:</strong></p>
                            <?php
                            $status_class = '';
                            $status_text = '';
                            $status = isset($donhang['status']) && !empty($donhang['status']) ? $donhang['status'] : 'pending';
                            switch($status) {
                                case 'pending':
                                    $status_class = 'warning';
                                    $status_text = 'Chờ xử lý';
                                    break;
                                case 'processing':
                                    $status_class = 'info';
                                    $status_text = 'Đang xử lý';
                                    break;
                                case 'completed':
                                    $status_class = 'success';
                                    $status_text = 'Hoàn thành';
                                    break;
                                case 'cancelled':
                                    $status_class = 'danger';
                                    $status_text = 'Đã hủy';
                                    break;
                                default:
                                    $status_class = 'warning';
                                    $status_text = 'Chờ xử lý';
                                    break;
                            }
                            ?>
                            <span class="badge bg-<?php echo $status_class ?>"><?php echo $status_text ?></span>

                            <p class="mb-1 mt-3"><strong>Trạng thái kiểm duyệt:</strong></p>
                            <?php
                            $approval_class = '';
                            $approval_text = '';
                            $status_approval = isset($donhang['status_approval']) && !empty($donhang['status_approval']) ? $donhang['status_approval'] : 'pending';
                            switch($status_approval) {
                                case 'pending':
                                    $approval_class = 'warning';
                                    $approval_text = 'Chờ duyệt';
                                    break;
                                case 'approved':
                                    $approval_class = 'success';
                                    $approval_text = 'Đã duyệt';
                                    break;
                                case 'rejected':
                                    $approval_class = 'danger';
                                    $approval_text = 'Từ chối';
                                    break;
                            }
                            ?>
                            <span class="badge bg-<?php echo $approval_class ?>"><?php echo $approval_text ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Thông tin khách hàng</h5>
                    <div class="customer-info mt-3">
                        <div class="info-item"><i class="fas fa-user me-2"></i><strong>Họ tên:</strong> <?php echo $donhang['fullname']; ?></div>
                        <div class="info-item"><i class="fas fa-envelope me-2"></i><strong>Email:</strong> <?php echo $donhang['email']; ?></div>
                        <div class="info-item"><i class="fas fa-phone me-2"></i><strong>Số điện thoại:</strong> <?php echo $donhang['phone']; ?></div>
                        <div class="info-item"><i class="fas fa-credit-card me-2"></i><strong>Phương thức thanh toán:</strong> <?php echo ucfirst($donhang['payment_method']); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chi tiết sản phẩm -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">Chi tiết sản phẩm</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Sản phẩm</th>
                            <th class="text-center">Số lượng</th>
                            <th class="text-end">Đơn giá</th>
                            <th class="text-end">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $tong_tien = 0;
                        while ($row = mysqli_fetch_assoc($result)) {
                            $tong_sp = $row['soluong'] * $row['giasp'];
                            $tong_tien += $tong_sp;
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['tensanpham']); ?></td>
                            <td class="text-center"><?php echo $row['soluong']; ?></td>
                            <td class="text-end"><?php echo number_format($row['giasp'], 0, ',', '.'); ?> đ</td>
                            <td class="text-end"><?php echo number_format($tong_sp, 0, ',', '.'); ?> đ</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
                            <td class="text-end"><strong><?php echo number_format($tong_tien, 0, ',', '.'); ?> đ</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Nút điều hướng -->
    <div class="action-buttons mt-4">
        <div class="d-flex justify-content-center flex-wrap gap-3">
            <a href="javascript:history.back()" class="btn btn-secondary d-flex align-items-center">
                <i class="fas fa-arrow-left me-2"></i>Quay lại
            </a>
            
            <!-- Nút cập nhật trạng thái đơn hàng -->
            <?php if (!isset($donhang['status']) || $donhang['status'] == '') { $donhang['status'] = 'pending'; } ?>
            <?php if (!isset($donhang['status']) || empty($donhang['status']) || $donhang['status'] == 'pending') { $donhang['status'] = 'pending'; } ?>
            <?php if ($donhang['status'] == 'pending') { ?>
         
            <?php } elseif ($donhang['status'] == 'processing') { ?>
            <button class="btn btn-success d-flex align-items-center" onclick="updateStatus('completed')">
                <i class="fas fa-check-circle me-2"></i>Hoàn thành
            </button>
            <button class="btn btn-danger d-flex align-items-center" onclick="updateStatus('cancelled')">
                <i class="fas fa-times-circle me-2"></i>Hủy đơn
            </button>
            <?php } ?>
            
            <!-- Nút xóa đơn hàng -->
            <button class="btn btn-danger d-flex align-items-center" onclick="deleteOrder()">
                <i class="fas fa-trash me-2"></i>Xóa đơn hàng
            </button>

            <!-- Nút kiểm duyệt đơn hàng -->
            <?php if (!isset($donhang['status_approval']) || empty($donhang['status_approval']) || $donhang['status_approval'] == 'pending') { $donhang['status_approval'] = 'pending'; } ?>
            <?php if ($donhang['status_approval'] == 'pending') { ?>
            <button class="btn btn-success d-flex align-items-center" onclick="updateApproval('approved')">
                <i class="fas fa-check me-2"></i>Duyệt đơn
            </button>
            <button class="btn btn-danger d-flex align-items-center" onclick="updateApproval('rejected')">
                <i class="fas fa-ban me-2"></i>Từ chối
            </button>
            <?php } ?>
        </div>
    </div>
    </div>
</div>

<script>
function updateStatus(status) {
    Swal.fire({
        title: 'Xác nhận',
        text: 'Bạn có chắc muốn cập nhật trạng thái đơn hàng?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Đồng ý',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append('id_donhang', <?php echo $id_donhang; ?>);
            formData.append('action', 'update_status');
            formData.append('status', status);

            fetch('modules/quanlydonhang/xuly.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Thành công!',
                        text: data.message,
                        icon: 'success'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    throw new Error(data.message || 'Đã xảy ra lỗi khi cập nhật trạng thái');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Lỗi!',
                    text: error.message || 'Đã xảy ra lỗi khi cập nhật trạng thái',
                    icon: 'error'
                });
            });
        }
    });
}

function deleteOrder() {
    Swal.fire({
        title: 'Xác nhận xóa',
        text: 'Bạn có chắc chắn muốn xóa đơn hàng này? Hành động này không thể hoàn tác!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Đồng ý',
        cancelButtonText: 'Hủy',
        confirmButtonColor: '#d33'
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append('id_donhang', <?php echo $id_donhang; ?>);
            formData.append('action', 'delete_order');

            fetch('modules/quanlydonhang/xuly.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Thành công!',
                        text: 'Đơn hàng đã được xóa thành công',
                        icon: 'success'
                    }).then(() => {
                        window.location.href = 'index.php?action=quanlydonhang&query=lietke';
                    });
                } else {
                    throw new Error(data.message || 'Đã xảy ra lỗi khi xóa đơn hàng');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Lỗi!',
                    text: error.message || 'Đã xảy ra lỗi khi xóa đơn hàng',
                    icon: 'error'
                });
            });
        }
    });
}

function updateApproval(status) {
    Swal.fire({
        title: 'Xác nhận',
        text: 'Bạn có chắc muốn cập nhật trạng thái kiểm duyệt?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Đồng ý',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append('id_donhang', <?php echo $id_donhang; ?>);
            formData.append('action', 'update_approval');
            formData.append('status_approval', status);

            fetch('modules/quanlydonhang/xuly.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Thành công!',
                        text: data.message,
                        icon: 'success'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    throw new Error(data.message || 'Đã xảy ra lỗi khi cập nhật trạng thái kiểm duyệt');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Lỗi!',
                    text: error.message || 'Đã xảy ra lỗi khi cập nhật trạng thái kiểm duyệt',
                    icon: 'error'
                });
            });
        }
    });
}
</script>