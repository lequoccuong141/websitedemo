<?php 
session_start();
if (!isset($_SESSION['dangnhap'])){
      header('Location:login.php');

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Admincp</title>
      <link rel="stylesheet" type="text/css" href="css/styleadmincp.css">
     
</head>
<body>
      <h3 class="admincp-title">hello</h3>
      <div class="admincp-wrapper">
      <?php
                  include("config/config.php");
                  include("modules/header.php");
                  include("modules/menu.php");
                  include("modules/main.php");
                  include("modules/footer.php");
      ?>
      </div>
</body>
</html>