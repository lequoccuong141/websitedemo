
<html lang="en">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" type="text/css" href="css/style.css?v=1.0">
      <title>Web phu kien dien thoai</title>
</head>
<body>
      <div class="wrapper">
            <?php
            session_start();
                  include("admincp/config/config.php");
                  include("pages/header.php");
                  include("pages/menu.php");
                  include("pages/main.php");
                  include("pages/footer.php");
            ?>

      </div>
</body>
</html>
