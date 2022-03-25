<?php
    session_start();
    require_once('./utils/utility.php');
    require_once('./database/dbhelper.php');
    $id = getCookie('Id');
    $sql1 = "select nguoidung.* from nguoidung where Id ='$id'";
    $data = executeResult($sql1);
    foreach($data as $value){
        $role = $value['VaiTro'];
    }
    require_once('./layoutAdmin/header.php');
?>
<div class="container-fluid">
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Tên Loại bệnh</label>
            <input type="text" class="form-control"  id="title" name="title">
        </div>
        <div class="form-group">
            <label>Nội dung</label>
            <textarea class="form-control" name="content" id="content" value="" cols="30" rows="10"></textarea>
        </div> 
        <button  type="submit" class="btn btn-success ">Thêm</button> 
    </form>
</div>
<?php
    if(!empty($_POST)){
        $title = getPOST('title');
        $content = getPOST('content');
        $creat_at = date('Y-m-d');
        if(!empty($title)&&!empty($content)){
            $sql = "insert into loaibenh(Id_ND,TenLoaiBenh,NoiDung) values ('$id','$title','$content')";
            execute($sql);
            echo"<script>alert('Thêm thành công')</script>";
            die();
        }
        else{
            echo"<script>alert('Vui lòng điền đầy đủ thông tin!')</script>";
        }
    }
?>