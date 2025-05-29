<?php
include('../admincp/config/config.php');

// Xử lý phân trang
$items_per_page = 10;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $items_per_page;

// Xử lý lọc theo trạng thái
$status_filter = isset($_GET['status']) ? $_GET['status'] : 'all';
$status_condition = $status_filter != 'all' ? "WHERE status = '$status_filter'" : '';

// Truy vấn tổng số đơn hàng
$sql_count = "SELECT COUNT(*) as total FROM tbl_donhang $status_condition";
$count_result = mysqli_query($mysqli, $sql_count);
$total_items = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_items / $items_per_page);

// Truy vấn đơn hàng với phân trang
$sql_donhang = "SELECT * FROM tbl_donhang $status_condition ORDER BY date_order DESC LIMIT $offset, $items_per_page";
$query_donhang = mysqli_query($mysqli, $sql_donhang);

// Thống kê doanh thu theo tháng hiện tại
$month = date('m');
$year = date('Y');
$sql_revenue = "SELECT SUM(total) as monthly_revenue FROM tbl_donhang WHERE MONTH(date_order) = $month AND YEAR(date_order) = $year";
$revenue_result = mysqli_query($mysqli, $sql_revenue);
$monthly_revenue = mysqli_fetch_assoc($revenue_result)['monthly_revenue'];
?>

<style>
.stats-card {
    transition: transform 0.3s ease;
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

.stats-card:hover {
    transform: translateY(-5px);
}

.stats-card .card-body {
    padding: 1.5rem;
}

.stats-card .card-title {
    font-size: 1rem;
    font-weight: 500;
    margin-bottom: 1rem;
    opacity: 0.9;
}

.stats-card .card-text {
    font-size: 1.8rem;
    font-weight: 600;
    margin-bottom: 0;
}

.stats-icon {
    font-size: 2rem;
    margin-bottom: 1rem;
    opacity: 0.8;
}

.table-hover tbody tr {
    transition: all 0.3s ease;
    border-left: 3px solid transparent;
}

.table-hover tbody tr:hover {
    background-color: rgba(13, 202, 240, 0.05);
    border-left: 3px solid #0dcaf0;
    transform: translateX(5px);
}

.table thead th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.badge {
    padding: 0.6em 1em;
    font-weight: 500;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.btn-group .btn {
    margin: 0 2px;
    border-radius: 5px !important;
    transition: all 0.3s ease;
}

.btn-info {
    color: #fff;
    background-color: #0dcaf0;
    border-color: #0dcaf0;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(13, 202, 240, 0.3);
}

.btn-info:hover {
    background-color: #31d2f2;
    border-color: #25cff2;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(13, 202, 240, 0.4);
}

.table td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
}

.text-success {
    color: #198754 !important;
}

.text-primary {
    color: #0d6efd !important;
}
</style>

<!-- Thêm thư viện Chart.js, Bootstrap Modal và SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="modules/quanlydonhang/quanlydonhang.js"></script>

<div class="container-fluid py-4">
    <!-- Biểu đồ doanh thu -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row mb-3">
                
            </div>
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- Thống kê nhanh -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card stats-card bg-primary text-white">
                <div class="card-body">
                    <div class="stats-icon"><i class="fas fa-chart-line"></i></div>
                    <h5 class="card-title">Doanh thu tháng <?php echo $month ?>-<?php echo $year ?></h5>
                    <h3 class="card-text"><?php echo number_format($monthly_revenue, 0, ',', '.') ?> đ</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stats-card bg-success text-white">
                <div class="card-body">
                    <div class="stats-icon"><i class="fas fa-shopping-cart"></i></div>
                    <h5 class="card-title">Tổng đơn hàng</h5>
                    <h3 class="card-text"><?php echo $total_items ?></h3>
                </div>
            </div>
        </div>
    </div>

   
    <!-- Bảng đơn hàng -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Khách hàng</th>
                            <th>Liên hệ</th>
                            <th class="text-end">Tổng tiền</th>
                            <th>Ngày đặt</th>
                            <th>Trạng thái</th>
                            
                            <th>Kiểm duyệt</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_array($query_donhang)) { ?>
                        <tr>
                            <td class="text-center fw-bold text-primary">#<?php echo $row['id_donhang']; ?></td>
                            <td class="fw-medium"><?php echo $row['fullname']; ?></td>
                            <td>
                                <div class="text-dark"><?php echo $row['email']; ?></div>
                                <div class="text-muted small"><?php echo $row['phone']; ?></div>
                            </td>
                            <td class="text-end fw-bold text-success"><?php echo number_format($row['total'], 0, ',', '.') ?> đ</td>
                            <td class="text-nowrap"><?php echo date('d/m/Y H:i', strtotime($row['date_order'])); ?></td>
                            <td>
                                <?php
                                $status_class = '';
                                $status_text = '';
                                $status = isset($row['status']) ? $row['status'] : 'pending';
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
                                }
                                ?>
                                <span class="badge bg-<?php echo $status_class ?> rounded-pill"><?php echo $status_text ?></span>
                                <div class="mt-2">
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-primary btn-status" data-order-id="<?php echo $row['id_donhang']; ?>" data-status="processing">Xử lý</button>
                                        <button class="btn btn-outline-info btn-status" data-order-id="<?php echo $row['id_donhang']; ?>" data-status="shipping">Giao hàng</button>
                                        <button class="btn btn-outline-success btn-status" data-order-id="<?php echo $row['id_donhang']; ?>" data-status="completed">Hoàn thành</button>
                                        <button class="btn btn-outline-danger btn-status" data-order-id="<?php echo $row['id_donhang']; ?>" data-status="cancelled">Hủy</button>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <?php
                                $approval_class = '';
                                $approval_text = '';
                                $approval_status = isset($row['status_approval']) ? $row['status_approval'] : 'pending';
                                switch($approval_status) {
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
                                <span class="badge bg-<?php echo $approval_class ?> rounded-pill"><?php echo $approval_text ?></span>
                               
                                </div>
                            </td>
                            <td class="text-capitalize"><?php echo $row['payment_method']; ?></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="chitietdonhang.php?id=<?php echo $row['id_donhang']; ?>" >
                                        <i class="fas fa-eye me-1"></i>Chi tiết
                                   
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

          
           

            <!-- Phân trang -->
            <?php if($total_pages > 1) { ?>
            <nav class="mt-4" aria-label="Điều hướng trang">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php echo $current_page == 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?php echo $current_page-1 ?>&status=<?php echo $status_filter ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php
                    $start_page = max(1, $current_page - 2);
                    $end_page = min($total_pages, $start_page + 4);
                    if($start_page > 1) { ?>
                        <li class="page-item"><a class="page-link" href="?page=1&status=<?php echo $status_filter ?>">1</a></li>
                        <?php if($start_page > 2) { ?>
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php } ?>
                    <?php }
                    for($i = $start_page; $i <= $end_page; $i++) { ?>
                        <li class="page-item <?php echo $i == $current_page ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?php echo $i ?>&status=<?php echo $status_filter ?>"><?php echo $i ?></a>
                        </li>
                    <?php }
                    if($end_page < $total_pages) { 
                        if($end_page < $total_pages - 1) { ?>
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php } ?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo $total_pages ?>&status=<?php echo $status_filter ?>"><?php echo $total_pages ?></a></li>
                    <?php } ?>
                    <li class="page-item <?php echo $current_page == $total_pages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?php echo $current_page+1 ?>&status=<?php echo $status_filter ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <?php } ?>
        </div>
    </div>
</div>
