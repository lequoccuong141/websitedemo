<?php
$admin_username = $_SESSION['dangnhap'];
$current_time = date('H:i');
$current_date = date('d/m/Y');
?>
<div class="welcome-dashboard">
    <div class="welcome-header">
        <h2>Chào mừng, <?php echo $admin_username; ?>!</h2>
        <p class="timestamp">Thời gian: <?php echo $current_time; ?> - Ngày: <?php echo $current_date; ?></p>
    </div>
    <div class="dashboard-stats">
        <div class="stat-box">
            <h3>Trạng thái hệ thống</h3>
            <p>Hoạt động bình thường</p>
        </div>
    </div>
</div>

<style>
.welcome-dashboard {
    padding: 20px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin: 20px;
}

.welcome-header {
    border-bottom: 2px solid #eee;
    padding-bottom: 15px;
    margin-bottom: 20px;
}

.welcome-header h2 {
    color: #333;
    margin: 0 0 10px 0;
    font-size: 24px;
}

.timestamp {
    color: #666;
    font-size: 14px;
    margin: 0;
}

.dashboard-stats {
    display: flex;
    gap: 20px;
    margin-top: 20px;
}

.stat-box {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 6px;
    flex: 1;
}

.stat-box h3 {
    color: #444;
    margin: 0 0 10px 0;
    font-size: 16px;
}

.stat-box p {
    color: #28a745;
    margin: 0;
    font-weight: 500;
}
</style>