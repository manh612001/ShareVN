<?php
    session_start();
    require_once('./utils/utility.php');
    require_once('./database/dbhelper.php');
    $user = getToken();
    $rs = $user['Id'];
    $role = $user['Role'];
    $sql = "select * from User where Id ='$rs'"; 
    $data = executeResult($sql);
    $query = "select * from User order by Role ASC"; 
    $dt = executeResult($query);
    $qr = "select count(*) as total from User "; 
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
                <th>Rold</th>
                <th style="width:10%;"></th>
                <th style="width:10%;"></th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($dt as $value) {
                    echo'<tr>
                        <td>'.$value['Name'].'</td>
                        <td>'.$value['Email'].'</td>
                        <td>'.$value['Role'].'</td>
                        <td>';
                        if(strtolower($value['Role'])!='admin'){
                            echo '
                            <button class="btn btn-primary" onclick="Add('.$value['Id'].')">Thêm Admin</button>';
                        }
                        echo'</td>
                        <td>';
                        if(strtolower($value['Role'])=='admin'){
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
