<?php
session_start();
include('config/config.php');

if(isset($_POST['dangnhap'])){
    $taikhoan = $_POST['username'];
    $matkhau = $_POST['password']; // Không sử dụng md5()

    $sql = "SELECT * FROM tbl_admin WHERE username = '".$taikhoan."' AND password = '".$matkhau."' LIMIT 1";
    $row = mysqli_query($mysqli, $sql);
    $count = mysqli_num_rows($row);

    if($count > 0){
        $_SESSION['dangnhap'] = $taikhoan;
        header("Location: index.php");
        exit();
    } else {
        echo '<script>alert("Tài khoản hoặc mật khẩu không đúng!");</script>';
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Đăng nhập Admincp</title>
      <style type="text/css">
            body{
                  background-color: #f2f2f2;
            }
            .wrapper-login {
                  width: 15%;
                  margin: 0 auto;
            }
            table.table-login {
                  width: 100%;
            }
            table.table-login tr td {
                  padding: 5px;
            }
      </style>
</head>
<body>

      <div class="wrapper-login">
            <form action="" autocomplete="off" method="POST">
                  <table border="1" class="table-login" style="text-align: center; border-collapse:collapse;">
                        <tr>
                              <td colspan="2"><h3>Đăng nhập Admin</h3></td>
                        </tr>

                        <tr>
                              <td>Tài khoản</td>
                              <td><input type="text" name="username"></td>
                        </tr>

                        <tr>
                              <td>Mật khẩu</td>
                              <td><input type="password" name="password"></td>
                        </tr>

                        <tr>
                              <td colspan="2"><input type="submit" name="dangnhap" value="Đăng nhập"></td>
                        </tr>

                  </table>
            </form>
      </div>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>
</html>

