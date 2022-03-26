<?php

function getGet($key){
    $value = '';
    if(isset($_GET[$key])){
        $value = $_GET[$key];
    }
    return trim($value);
}
function getPOST($key){
    $value = '';
    if(isset($_POST[$key])){
        $value = $_POST[$key];
    }
    return trim($value);
}
function getRequest($key){
    $value = '';
    if(isset($_REQUEST[$key])){
        $value = $_REQUEST[$key];
        
    }
    return trim($value);
}
function getCookie($key){
    $value = '';
    if(isset($_COOKIE[$key])){
        $value = $_COOKIE[$key];
    }
    return trim($value);
}

function uploadFile($key, $rootPath = "./") {
    if(!isset($_FILES[$key]) || !isset($_FILES[$key]['name']) || $_FILES[$key]['name'] == '') {
        return '';
    }

    $pathTemp = $_FILES[$key]["tmp_name"];

    $filename = $_FILES[$key]['name'];
    //filename -> remove special character, ..., ...

    $newPath="upload/".$filename;

    move_uploaded_file($pathTemp, $rootPath.$newPath);

    return $newPath;
}
function path($thumbnail, $Url = "./") { // thêm đường dẫn folder $Url

    return $Url.$thumbnail;
}
