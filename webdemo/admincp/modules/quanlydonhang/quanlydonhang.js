// Khởi tạo biểu đồ doanh thu
function initRevenueChart() {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Doanh thu',
                data: [],
                backgroundColor: 'rgba(75, 192, 192, 0.8)',
                borderColor: 'rgb(75, 192, 192)',
                borderWidth: 1,
                borderRadius: 5,
                maxBarThickness: 50
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Biểu đồ doanh thu theo ngày',
                    font: {
                        size: 16,
                        weight: 'bold'
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += new Intl.NumberFormat('vi-VN', {
                                style: 'currency',
                                currency: 'VND'
                            }).format(context.parsed.y);
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('vi-VN', {
                                style: 'currency',
                                currency: 'VND'
                            }).format(value);
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            animation: {
                duration: 1000,
                easing: 'easeInOutQuart'
            }
        }
    });
    return chart;
}

// Lấy dữ liệu doanh thu
async function fetchRevenueData(startDate = null, endDate = null) {
    try {
        let url = 'modules/quanlydonhang/get_revenue_data.php';
        if (startDate && endDate) {
            url += `?start_date=${startDate}&end_date=${endDate}`;
        }
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error('Không thể tải dữ liệu doanh thu');
        }
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Lỗi khi lấy dữ liệu doanh thu:', error);
        Swal.fire({
            title: 'Lỗi!',
            text: error.message,
            icon: 'error'
        });
        return null;
    }
}

// Cập nhật biểu đồ
async function updateChart(chart) {
    const data = await fetchRevenueData();
    if (data) {
        chart.data.labels = data.labels;
        chart.data.datasets[0].data = data.values;
        chart.update();
    }
}

// Xử lý tìm kiếm
function initSearch() {
    const searchInput = document.getElementById('searchInput');
    const tbody = document.querySelector('table tbody');
    const originalRows = [...tbody.querySelectorAll('tr')];

    searchInput.addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase();
        const filteredRows = originalRows.filter(row => {
            const text = row.textContent.toLowerCase();
            return text.includes(searchTerm);
        });

        tbody.innerHTML = '';
        filteredRows.forEach(row => tbody.appendChild(row.cloneNode(true)));
    });
}

// Khởi tạo biểu đồ và các chức năng khi trang được tải
document.addEventListener('DOMContentLoaded', function() {
    const chart = initRevenueChart();
    updateChart(chart);
    initSearch();
    initOrderControls();
    initDateFilter(chart);
});

// Khởi tạo bộ lọc theo ngày
function initDateFilter(chart) {
    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');
    const filterBtn = document.getElementById('filterDate');

    if (startDateInput && endDateInput && filterBtn) {
        filterBtn.addEventListener('click', async () => {
            const startDate = startDateInput.value;
            const endDate = endDateInput.value;
            if (startDate && endDate) {
                const data = await fetchRevenueData(startDate, endDate);
                if (data) {
                    chart.data.labels = data.labels;
                    chart.data.datasets[0].data = data.values;
                    chart.update('show');
                }
            }
        });
    }
}

// Khởi tạo các nút điều khiển đơn hàng
function initOrderControls() {
    document.querySelectorAll('.btn-status').forEach(btn => {
        btn.addEventListener('click', function() {
            const orderId = this.dataset.orderId;
            const status = this.dataset.status;
            Swal.fire({
                title: 'Xác nhận thay đổi',
                text: `Bạn có chắc chắn muốn thay đổi trạng thái đơn hàng #${orderId}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    updateOrderStatus(orderId, status);
                }
            });
        });
    });

    document.querySelectorAll('.btn-approval').forEach(btn => {
        btn.addEventListener('click', function() {
            const orderId = this.dataset.orderId;
            const approval = this.dataset.approval;
            Swal.fire({
                title: 'Xác nhận kiểm duyệt',
                text: `Bạn có chắc chắn muốn ${approval === 'approved' ? 'duyệt' : 'từ chối'} đơn hàng #${orderId}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    updateApprovalStatus(orderId, approval);
                }
            });
        });
    });
}

// Cập nhật trạng thái đơn hàng
function updateOrderStatus(orderId, status) {
    const formData = new FormData();
    formData.append('id_donhang', orderId);
    formData.append('action', 'update_status');
    formData.append('status', status);

    fetch('modules/quanlydonhang/xuly.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire('Thành công', 'Đã cập nhật trạng thái đơn hàng', 'success')
            .then(() => {
                location.reload();
            });
        } else {
            Swal.fire('Lỗi', data.message || 'Không thể cập nhật trạng thái', 'error');
        }
    })
    .catch(error => {
        console.error('Lỗi:', error);
        Swal.fire('Lỗi', 'Không thể cập nhật trạng thái', 'error');
    });

    Swal.fire({
        title: 'Xác nhận thay đổi',
        text: `Bạn có chắc chắn muốn ${statusText} đơn hàng #${orderId}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý',
        cancelButtonText: 'Hủy bỏ'
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append('id_donhang', orderId);
            formData.append('action', 'update_status');
            formData.append('status', status);

            fetch('modules/quanlydonhang/xuly.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Không thể cập nhật trạng thái đơn hàng');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Thành công!',
                        text: 'Cập nhật trạng thái thành công',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    throw new Error(data.message || 'Lỗi không xác định');
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
                Swal.fire({
                    title: 'Lỗi!',
                    text: error.message,
                    icon: 'error'
                });
            });
        }
    });
}

// Cập nhật trạng thái kiểm duyệt
function updateApprovalStatus(orderId, approval) {
    let approvalText = approval === 'approved' ? 'duyệt' : 'từ chối';

    Swal.fire({
        title: 'Xác nhận thay đổi',
        text: `Bạn có chắc chắn muốn ${approvalText} đơn hàng #${orderId}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý',
        cancelButtonText: 'Hủy bỏ'
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append('id_donhang', orderId);
            formData.append('action', 'update_approval');
            formData.append('status_approval', approval);

            fetch('modules/quanlydonhang/xuly.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Không thể cập nhật trạng thái kiểm duyệt');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Thành công!',
                        text: 'Cập nhật trạng thái kiểm duyệt thành công',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    throw new Error(data.message || 'Lỗi không xác định');
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
                Swal.fire({
                    title: 'Lỗi!',
                    text: error.message,
                    icon: 'error'
                });
            });
        }
    });
}

// Hiển thị chi tiết đơn hàng trong modal
function showOrderDetails(orderId) {
    fetch(`modules/quanlydonhang/get_order_details.php?id=${orderId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Không thể tải chi tiết đơn hàng');
            }
            return response.json();
        })
        .then(data => {
            const modal = new bootstrap.Modal(document.getElementById('orderModal'));
            const formatCurrency = (value) => new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(value);

            document.getElementById('modalOrderId').textContent = `#${orderId}`;
            document.getElementById('modalCustomerInfo').innerHTML = `
                <div class="customer-info">
                    <div class="info-item"><i class="fas fa-user me-2"></i>${data.customer_name}</div>
                    <div class="info-item"><i class="fas fa-envelope me-2"></i>${data.email}</div>
                    <div class="info-item"><i class="fas fa-phone me-2"></i>${data.phone}</div>
                    <div class="info-item"><i class="fas fa-map-marker-alt me-2"></i>${data.address}</div>
                    <div class="info-item mt-2">
                        <strong>Trạng thái đơn hàng: </strong>
                        <span class="badge bg-${getStatusClass(data.status)}">${getStatusText(data.status)}</span>
                    </div>
                    <div class="info-item mt-2">
                        <strong>Trạng thái kiểm duyệt: </strong>
                        <span class="badge bg-${getApprovalClass(data.status_approval)}">${getApprovalText(data.status_approval)}</span>
                    </div>
                </div>
            `;
            
            const productList = data.products.map(product => `
                <tr>
                    <td class="product-name">${product.name}</td>
                    <td class="text-center">${product.quantity}</td>
                    <td class="text-end">${formatCurrency(product.price)}</td>
                    <td class="text-end">${formatCurrency(product.total)}</td>
                </tr>
            `).join('');
            
            document.getElementById('modalProductList').innerHTML = productList;
            document.getElementById('modalTotal').textContent = formatCurrency(data.total);
            
            modal.show();
        })
        .catch(error => {
            console.error('Lỗi khi lấy chi tiết đơn hàng:', error);
            Swal.fire({
                title: 'Lỗi!',
                text: 'Không thể tải chi tiết đơn hàng',
                icon: 'error'
            });
        });
}

function getStatusClass(status) {
    switch(status) {
        case 'pending': return 'warning';
        case 'processing': return 'info';
        case 'completed': return 'success';
        case 'cancelled': return 'danger';
        default: return 'warning';
    }
}

function getStatusText(status) {
    switch(status) {
        case 'pending': return 'Chờ xử lý';
        case 'processing': return 'Đang xử lý';
        case 'completed': return 'Hoàn thành';
        case 'cancelled': return 'Đã hủy';
        default: return 'Chờ xử lý';
    }
}

function getApprovalClass(status) {
    switch(status) {
        case 'pending': return 'warning';
        case 'approved': return 'success';
        case 'rejected': return 'danger';
        default: return 'warning';
    }
}

function getApprovalText(status) {
    switch(status) {
        case 'pending': return 'Chờ duyệt';
        case 'approved': return 'Đã duyệt';
        case 'rejected': return 'Từ chối';
        default: return 'Chờ duyệt';
    }
}
// Khởi tạo các chức năng khi trang được tải
document.addEventListener('DOMContentLoaded', () => {
    const chart = initRevenueChart();
    updateChart(chart);
    initSearch();

    // Cập nhật biểu đồ mỗi 5 phút
    setInterval(() => updateChart(chart), 300000);
});