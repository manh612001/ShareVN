<?php
  session_start();
  require_once('./utils/utility.php');
  require_once('./database/dbhelper.php');
  $id = getCookie('Id');
  if($id==null)
  {
    header('Location:./login.php');
    die();
  }
  $sql = "select * from nguoidung where id ='$id'";
  $data = executeResult($sql);
  foreach($data as $value){
    $name = $value['Ten'];
    $role = $value['VaiTro'];
  }
  
?>
    <!-- header-->
    <?php 
      if(strtolower($role) =="admin")
        require_once('./layoutAdmin/header.php');
      else
        require_once('./layout/header.php');
    ?>
    <!--End Header-->
    <!-- Main-->
    <?php
      if(strtolower($role) =="admin")
        require_once('./layoutAdmin/index.php');
      else
        require_once('./layout/index.php');
    ?>
    <!--End Main-->
    <!-- footer-->
    <?php require_once('./layout/footer.php')?>
    <!--End Footer-->
  </body>
</html>
