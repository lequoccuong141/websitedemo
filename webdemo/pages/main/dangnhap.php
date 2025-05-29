<?php
// Bắt đầu session nếu chưa
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_POST['dangnhap'])) {
    $error_message = '';
    
    // Kiểm tra và làm sạch dữ liệu đầu vào
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    
    if(empty($email) || empty($password)) {
        $error_message = 'Vui lòng điền đầy đủ thông tin đăng nhập.';
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Email không hợp lệ.';
    } else {
        // Sử dụng Prepared Statement để chống SQL Injection
        $stmt = $mysqli->prepare("SELECT id_dangky, tenkhachhang, email, diachi, matkhau, dienthoai FROM tbl_dangky WHERE email = ? LIMIT 1");
        
        // Kiểm tra nếu Prepared Statement thành công
        if ($stmt === false) {
            die('Lỗi SQL: ' . $mysqli->error);
        }
        
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // So sánh mật khẩu trực tiếp mà không mã hóa
            if($password === $user['matkhau']) {
                // Lưu thông tin session
                $_SESSION['dangky'] = $user['tenkhachhang'];
                $_SESSION['user_id'] = $user['id_dangky'];
                $_SESSION['email'] = $user['email'];
                
                // Chuyển hướng đến trang giỏ hàng
                header("Location: index.php");
                exit();
            } else {
                $error_message = 'Mật khẩu không đúng.';
            }
        } else {
            $error_message = 'Email không tồn tại trong hệ thống.';
        }
        $stmt->close();
    }
    
    if(!empty($error_message)) {
        echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($error_message) . '</div>';
    }
}
?>
    
<form action="" autocomplete="off" method="POST">
<table border="1" class="table-login" style="text-align: center; border-collapse:collapse;">
    <tr>
        <td colspan="2"><h3>Đăng nhập</h3></td>
    </tr>
    <tr>
        <td>Tài khoản</td>
        <td><input type="text" name="email" placeholder="email..." required></td>
    </tr>
    <tr>
        <td>Mật khẩu</td>
        <td><input type="password" name="password" placeholder="Mật khẩu..." required></td>
    </tr>
    <tr>
        <td colspan="2"><input type="submit" name="dangnhap" value="Đăng nhập"></td>
    </tr>
</table>
</form>
