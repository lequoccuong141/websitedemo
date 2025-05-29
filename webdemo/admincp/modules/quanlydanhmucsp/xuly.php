<?php
include('../../config/config.php');
session_start();

header('Content-Type: application/json; charset=utf-8');

// Bật báo cáo lỗi
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!$mysqli) {
    die(json_encode([
        'success' => false,
        'message' => 'Lỗi kết nối cơ sở dữ liệu'
    ]));
}

if(isset($_POST['themdanhmuc'])) {
    try {
        $tenloaisp = trim($_POST['tendanhmuc']);
        $thutu = trim($_POST['thutu']);

        if(empty($tenloaisp) || empty($thutu)) {
            echo json_encode([
                'success' => false,
                'message' => 'Vui lòng điền đầy đủ thông tin'
            ]);
            exit;
        }

        // Kiểm tra tên danh mục đã tồn tại chưa
        $sql_check = "SELECT * FROM tbl_danhmuc WHERE tendanhmuc = ?";
        $stmt = mysqli_prepare($mysqli, $sql_check);
        if (!$stmt) {
            throw new Exception("Lỗi chuẩn bị truy vấn: " . mysqli_error($mysqli));
        }
        
        mysqli_stmt_bind_param($stmt, "s", $tenloaisp);
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Lỗi thực thi truy vấn: " . mysqli_stmt_error($stmt));
        }
        
        $result = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($result) > 0) {
            echo json_encode([
                'success' => false,
                'message' => 'Tên danh mục này đã tồn tại'
            ]);
            exit;
        }

        // Thêm danh mục mới
        $sql_them = "INSERT INTO tbl_danhmuc(tendanhmuc, thutu) VALUES(?, ?)";
        $stmt = mysqli_prepare($mysqli, $sql_them);
        if (!$stmt) {
            throw new Exception("Lỗi chuẩn bị truy vấn thêm: " . mysqli_error($mysqli));
        }
        
        mysqli_stmt_bind_param($stmt, "si", $tenloaisp, $thutu);
        
        if(mysqli_stmt_execute($stmt)) {
            echo json_encode([
                'success' => true,
                'message' => 'Thêm danh mục thành công'
            ]);
        } else {
            throw new Exception("Lỗi thêm danh mục: " . mysqli_stmt_error($stmt));
        }
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
    exit;
} 

// Xử lý sửa danh mục
elseif(isset($_POST['suadanhmuc'])) {
    try {
        $tenloaisp = trim($_POST['tendanhmuc']);
        $thutu = trim($_POST['thutu']);
        $id_danhmuc = isset($_GET['iddanhmuc']) ? (int)$_GET['iddanhmuc'] : 0;

        if(empty($tenloaisp) || empty($thutu) || $id_danhmuc <= 0) {
            echo json_encode([
                'success' => false,
                'message' => 'Thiếu thông tin cần thiết'
            ]);
            exit;
        }

        // Kiểm tra xem danh mục có tồn tại không
        $check_exists = "SELECT id_danhmuc FROM tbl_danhmuc WHERE id_danhmuc = ?";
        $stmt = mysqli_prepare($mysqli, $check_exists);
        if (!$stmt) {
            throw new Exception("Lỗi chuẩn bị truy vấn: " . mysqli_error($mysqli));
        }
        mysqli_stmt_bind_param($stmt, "i", $id_danhmuc);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if(mysqli_num_rows($result) === 0) {
            echo json_encode([
                'success' => false,
                'message' => 'Không tìm thấy danh mục cần sửa'
            ]);
            exit;
        }

        // Kiểm tra tên danh mục có bị trùng không (trừ chính nó)
        $check_duplicate = "SELECT id_danhmuc FROM tbl_danhmuc WHERE tendanhmuc = ? AND id_danhmuc != ?";
        $stmt = mysqli_prepare($mysqli, $check_duplicate);
        if (!$stmt) {
            throw new Exception("Lỗi chuẩn bị truy vấn: " . mysqli_error($mysqli));
        }
        mysqli_stmt_bind_param($stmt, "si", $tenloaisp, $id_danhmuc);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($result) > 0) {
            echo json_encode([
                'success' => false,
                'message' => 'Tên danh mục này đã tồn tại'
            ]);
            exit;
        }

        // Cập nhật danh mục
        $sql_update = "UPDATE tbl_danhmuc SET tendanhmuc = ?, thutu = ? WHERE id_danhmuc = ?";
        $stmt = mysqli_prepare($mysqli, $sql_update);
        if (!$stmt) {
            throw new Exception("Lỗi chuẩn bị truy vấn cập nhật: " . mysqli_error($mysqli));
        }
        
        mysqli_stmt_bind_param($stmt, "sii", $tenloaisp, $thutu, $id_danhmuc);
        
        if(mysqli_stmt_execute($stmt)) {
            echo json_encode([
                'success' => true,
                'message' => 'Cập nhật danh mục thành công'
            ]);
        } else {
            throw new Exception("Lỗi cập nhật: " . mysqli_stmt_error($stmt));
        }
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
    exit;
}

// Xử lý xóa danh mục
elseif(isset($_GET['iddanhmuc'])) {
    $id = (int)$_GET['iddanhmuc'];

    // Kiểm tra xem danh mục có sản phẩm không
    $sql_check = "SELECT COUNT(*) as count FROM tbl_sanpham WHERE id_danhmuc = ?";
    $stmt = mysqli_prepare($mysqli, $sql_check);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if($row['count'] > 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Không thể xóa danh mục này vì đang có sản phẩm'
        ]);
        exit;
    }

    // Thực hiện xóa
    $sql_xoa = "DELETE FROM tbl_danhmuc WHERE id_danhmuc = ?";
    $stmt = mysqli_prepare($mysqli, $sql_xoa);
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    if(mysqli_stmt_execute($stmt)) {
        echo json_encode([
            'success' => true,
            'message' => 'Xóa danh mục thành công'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Lỗi khi xóa danh mục: ' . mysqli_error($mysqli)
        ]);
    }
    exit;
}

echo json_encode([
    'success' => false,
    'message' => 'Yêu cầu không hợp lệ'
]);
?>
