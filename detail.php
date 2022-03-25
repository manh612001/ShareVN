<?php
    session_start();
    require_once('./utils/utility.php');
    require_once('./database/dbhelper.php');
    
    $id = getGet('id');
    $sql = "select * from tintuc where id = $id";
    $dt = executeResult($sql);
    $rs = getCookie('Id');
    $sql1 = "select * from nguoidung where Id ='$rs'";
    $data = executeResult($sql1);
    foreach($data as $value){
        $role = $value['VaiTro'];
    }
    if(strtolower($role) =="admin")
        require_once('./layoutAdmin/header.php');
    else
        require_once('./layout/header.php');
?>
<div class="container">
    <?php
        foreach($dt as $value){
            echo '
                
                <div class="card">
                    <img src="'.path($value['HinhAnh']).'" style=" width:50%; margin:10px auto;"></img>
                    <div class="card-body">
                        <h4 style="text-align:center;" class="card-title">'.$value['TieuDe'].'</h4>
                        <p>Ngày đăng bài : '.$value['NgayTao'].'</p>
                        <p>'.$value['NoiDung'].'</p>
                    </div>
                </div>
                
            ';
        }
    ?>
</div>