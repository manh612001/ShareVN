<?php
    session_start();
    require_once('./utils/utility.php');
    require_once('./database/dbhelper.php');
    $id = getCookie('Id');
    $sql = "select nguoidung.* from nguoidung where Id ='$id'";
    $data = executeResult($sql);
    foreach($data as $value){
        $role = $value['VaiTro'];
    }
    if(strtolower($role)=='admin'){
        require_once('./layoutAdmin/header.php');
    }
    else{
        require_once('./layout/header.php');
    }
?>
<div class="container-fluid mt-5">
    <?php
    foreach($data as $value)
    {
        echo'
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>UserName</th>
                    <th>Password</th>
                    <th>Email</th>
                    <th>Role</th>
                    
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>'.$value['Ten'].'</td>
                    <td>'.$value['MatKhau'].'</td>
                    <td>'.$value['Email'].'</td>
                    <td>'.$value['VaiTro'].'</td>
                    
                </tr>
            </tbody>
        </table>';
    }
    ?>
</div> 
    