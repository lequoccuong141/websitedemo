<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <?php
            if(isset($_GET['action']) && $_GET['query']){
                $tam = $_GET['action'];
                $query = $_GET['query'];
                echo ucfirst(str_replace('quanly', 'Quản lý ', $tam));
            }else{
                $tam = '';
                $query = '';
                echo 'Dashboard';
            }
            ?>
        </h1>
    </div>

    <div class="content-wrapper">
        <?php
            if($tam=='quanlydanhmucsanpham' && $query=='them'){
                  include("modules/quanlydanhmucsp/them.php");
                  include("modules/quanlydanhmucsp/lietke.php");

            }elseif ($tam=='quanlydanhmucsanpham' && $query=='sua') {
                  include("modules/quanlydanhmucsp/sua.php");
                
            }elseif ($tam=='quanlysp' && $query=='them') {
                  include("modules/quanlysp/them.php");
                  include("modules/quanlysp/lietke.php");
                
            }elseif($tam=='quanlysp' && $query=='sua'){
                  include("modules/quanlysp/sua.php");
            }elseif($tam=='quanlyuser' && $query=='them'){
                  include("modules/quanlyuser/them.php");
                  include("modules/quanlyuser/lietke.php");
            }elseif($tam=='quanlyuser' && $query=='sua'){
                  include("modules/quanlyuser/sua.php");
            }elseif($tam=='quanlydonhang' && $query=='lietke'){
                  include("modules/quanlydonhang/quanlydonhang.php");
            }elseif($tam=='quanlydonhang' && $query=='sua'){
                  include("modules/quanlydonhang/sua.php");
            }
            else{
                  include("modules/dashboard.php");
            }
      ?>
    </div>
</main>

<style>
.table {
    margin-top: 1rem;
}

.btn-action {
    margin: 0 5px;
    padding: 5px 10px;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}
</style>