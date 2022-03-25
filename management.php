<?php
    session_start();
    require_once('./utils/utility.php');
    require_once('./database/dbhelper.php');
    $id = getCookie('Id');
    $sql = "select * from nguoidung where Id ='$id'"; 
    $data = executeResult($sql);
    foreach($data as $value){
        $role = $value['VaiTro'];
    }
    $query = "select * from nguoidung order by VaiTro ASC"; 
    $dt = executeResult($query);
    $qr = "select count(*) as total from nguoidung "; 
    $count = executeResult($qr);
    foreach($count as $value){
        $sl = $value['total'];
    }
    if(strtolower($role)=='admin'){
        require_once('./layoutAdmin/header.php');
    }
    else{
        require_once('./layout/header.php');
    }
?>
<div class="container-fluid">
    <h3 style="text-align:center;">Số lượng thành viên: <?=$sl?></h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>UserName</th>
                <th>Email</th>
                <th>Role</th>
                <th style="width:10%;"></th>
                <th style="width:10%;"></th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($dt as $value) {
                    echo'<tr>
                        <td>'.$value['Ten'].'</td>
                        <td>'.$value['Email'].'</td>
                        <td>'.$value['VaiTro'].'</td>
                        <td>';
                        if(strtolower($value['VaiTro'])!='admin'){
                            echo '
                            <button class="btn btn-primary" onclick="Add('.$value['Id'].')">Thêm Admin</button>';
                        }
                        echo'</td>
                        <td>';
                        if(strtolower($value['VaiTro'])=='admin'){
                            if($value['Id']!='1'){
                                echo '<button type ="submit" class="btn btn-warning" onclick="Del('.$value['Id'].')">Gỡ Admin</button>';
                            }
                        }
                        echo'</td>';
                        
                    echo'</tr>';
                }
            ?>
        </tbody>
    </table>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script> 
    function Add(id){
    $.post('api.php',{
        'id': id,
        'action':'add'
    },function(data){
        location.reload();
    })
    }
    function Del(id){
    $.post('api.php',{
        'id': id,
        'action':'del'
    },function(data){
        location.reload();
    })
    }    
</script>
