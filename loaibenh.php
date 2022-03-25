<?php
    session_start();
    require_once('./utils/utility.php');
    require_once('./database/dbhelper.php');
    $id = getCookie('Id');
    $sql = "select * from loaibenh order by Id DESC";
    $dt = executeResult($sql);
    $sql1 = "select nguoidung.* from nguoidung where Id ='$id'";
    $data = executeResult($sql1);
    foreach($data as $value){
        $role = $value['VaiTro'];
    }
    if(strtolower($role) =="admin")
        require_once('./layoutAdmin/header.php');
    else
        require_once('./layout/header.php');
    
?>
<div class="container-fluid">
    <?php
        if(strtolower($role)=='admin')
        {
            echo'<div class="mt-3"><a href="addLoaiBenh.php"><button class="btn btn-success">Thêm Loại Bệnh</button></a></div>';
        }
    ?>
    <div class="row mt-3" style="min-height:100vh;">
    <div class="col-md-3" style="background: rgb(141 177 249)">
    </div>
    <div class="col-md-7 ">
        <?php
            foreach($dt as $value){
                echo '
                    <div class = "card mb-5">
                        <div class = "card-body">
                            <h4 class = "card-title">'.$value['TenLoaiBenh'].'</h4>
                            <p>'.$value['NoiDung'].'</p>
                        </div>
                    </div>
                ';
            }
        ?>
        </div>
        <div class="col-md-2 " style="background: rgb(141 177 249)"></div>
    </div>
</div>
<?php
    if(!empty($_POST['search'])){
        $key = getPOST('search');
        $sql = "select * from loaibenh where TieuDe like '%$key%' ";
        $dt = executeResult($sql);
    }
?>

