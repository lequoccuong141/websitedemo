<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block bg-light admincp-sidebar">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">
                            <i class="fas fa-home me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=quanlydanhmucsanpham&query=them">
                            <i class="fas fa-list me-2"></i>Quản lý danh mục sản phẩm
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=quanlysp&query=them">
                            <i class="fas fa-box me-2"></i>Quản lý sản phẩm
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=quanlybaiviet&query=them">
                            <i class="fas fa-newspaper me-2"></i>Quản lý bài viết
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=quanlydanhmucbaiviet&query=them">
                            <i class="fas fa-folder me-2"></i>Quản lý danh mục bài viết
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=quanlyuser&query=them">
                            <i class="fas fa-users me-2"></i>Quản lý người dùng
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=quanlydonhang&query=lietke">
                            <i class="fas fa-shopping-cart me-2"></i>Quản lý đơn hàng
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>

<style>
.admincp-sidebar {
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    height: calc(100vh - 72px);
}

.sidebar .nav-link {
    color: #333;
    padding: 0.8rem 1rem;
    transition: all 0.3s ease;
}

.sidebar .nav-link:hover {
    background-color: #e9ecef;
    color: #007bff;
    transform: translateX(5px);
}

.sidebar .nav-link.active {
    background-color: #007bff;
    color: white;
}

.sidebar .nav-link i {
    width: 20px;
    text-align: center;
}
</style>