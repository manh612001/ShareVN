<?php
    session_start();
    require_once('./utils/utility.php');
    require_once('./database/dbhelper.php');
    $user = getToken();
    if($user== null){
        die();
    }
    if(!empty($_POST)){
        $action = getPOST('action');
        switch($action){
            case 'update':
                update();
                break;
            case 'delete':
                Delete();
                break;
            case 'delblog':
                DelBlog();
                break;
            case 'delpost':
                DelPost();
                break;
            case 'add':
                Add();
                break;
            case 'del':
                Del();
                break;     
        }
    }
    function Del(){
        $id = getPOST('id');
        $sql = "update nguoidung set VaiTro = 'thanhvien' where Id = '$id'";
        execute($sql);
    }
    function Add(){
        $id = getPOST('id');
        $sql = "update nguoidung set VaiTro = 'admin' where Id = '$id'";
        execute($sql);
    }
    function DelBlog(){
        $id = getPOST('id');
        $sql="delete from tintuc where Id = $id";
        execute($sql);
    }
    function Delete(){
        $id = getPOST('id');
        $sql="delete from baiviet where Id = $id";
        execute($sql);
    }
    function DelPost(){
        $id = getPOST('id');
        $sql="delete from binhluan where Id_BV = $id";
        execute($sql);
        $sql="delete from baiviet where Id = $id";
        execute($sql);
    }
    function update() {
        $id = getPost('id');
        $sql = "update baiviet set TrangThai = 1 where Id = $id";
        execute($sql);
    }
?>