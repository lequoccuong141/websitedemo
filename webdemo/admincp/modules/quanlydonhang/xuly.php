<?php
include('../../config/config.php');
session_start();

// Kiểm tra kết nối CSDL
if (!$mysqli) {
    die("Lỗi kết nối CSDL: " . mysqli_connect_error());
}

// Lấy thông tin từ request
$id_donhang = isset($_POST['id_donhang']) ? intval($_POST['id_donhang']) : 0;
$action = isset($_POST['action']) ? $_POST['action'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : '';
$status_approval = isset($_POST['status_approval']) ? $_POST['status_approval'] : '';

// Kiểm tra dữ liệu đầu vào
if ($id_donhang <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID đơn hàng không hợp lệ']);
    exit();
}

// Xử lý các hành động
switch($action) {
    case 'delete_order':
        // Xóa chi tiết đơn hàng
        $sql_delete_details = "DELETE FROM tbl_chitietdonhang WHERE id_donhang = ?";
        $stmt = mysqli_prepare($mysqli, $sql_delete_details);
        mysqli_stmt_bind_param($stmt, "i", $id_donhang);
        $result_details = mysqli_stmt_execute($stmt);

        if (!$result_details) {
            echo json_encode([
                'success' => false,
                'message' => 'Lỗi khi xóa chi tiết đơn hàng: ' . mysqli_error($mysqli)
            ]);
            exit();
        }

        // Xóa đơn hàng
        $sql_delete_order = "DELETE FROM tbl_donhang WHERE id_donhang = ?";
        $stmt = mysqli_prepare($mysqli, $sql_delete_order);
        mysqli_stmt_bind_param($stmt, "i", $id_donhang);
        $result_order = mysqli_stmt_execute($stmt);

        if ($result_order) {
            echo json_encode([
                'success' => true,
                'message' => 'Xóa đơn hàng thành công'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Lỗi khi xóa đơn hàng: ' . mysqli_error($mysqli)
            ]);
        }
        break;

    case 'update_status':
        if (empty($status)) {
            echo json_encode(['success' => false, 'message' => 'Trạng thái không hợp lệ']);
            exit();
        }

        $sql = "UPDATE tbl_donhang SET status = ? WHERE id_donhang = ?";
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "si", $status, $id_donhang);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Cập nhật trạng thái thành công',
                'status' => $status
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Lỗi khi cập nhật trạng thái: ' . mysqli_error($mysqli)
            ]);
        }
        break;

    case 'update_approval':
        if (empty($status_approval)) {
            echo json_encode(['success' => false, 'message' => 'Trạng thái kiểm duyệt không hợp lệ']);
            exit();
        }

        $sql = "UPDATE tbl_donhang SET status_approval = ? WHERE id_donhang = ?";
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "si", $status_approval, $id_donhang);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Cập nhật trạng thái kiểm duyệt thành công',
                'status_approval' => $status_approval
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Lỗi khi cập nhật trạng thái kiểm duyệt: ' . mysqli_error($mysqli)
            ]);
        }
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Hành động không hợp lệ']);
        break;
}

mysqli_close($mysqli);
?>