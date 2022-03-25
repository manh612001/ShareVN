<?php
    require_once('./utils/utility.php');
    require_once('./database/dbhelper.php');
    $sql = "select * from baiviet where TrangThai = 1";
    $dt = executeResult($sql);
    $rs = getCookie('Id');
    $sql1 = "select nguoidung.* from nguoidung where Id ='$rs'";
    $data = executeResult($sql1);
    foreach($data as $value){
      $role = $value['VaiTro'];
    }
    $qr = "select nguoidung.*,baiviet.* from baiviet inner join nguoidung on baiviet.Id_ND = nguoidung.Id where baiviet.TrangThai = 1 order by baiviet.Id DESC";
    $post = executeResult($qr);
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-3" style="background: rgb(141 177 249)"></div>
    <div class="col-md-7" style="background: rgb(244 245 247)">
        <div style=" margin: 15px auto; width: 85%; padding: 15px; border: 2px solid black; border-radius: 10px; ">
          <div id="box-icon">
            <i class="fa-solid fa-user-large" id="icon-avatar"></i>
          </div>
          <button type="button"class="btn"style="background: #b2bec3; margin-left: 15px;border-radius:50px;"data-toggle="modal"data-target="#myModal"><?=$name?> Bạn hãy nhập dữ liệu vào đây!</button>
        </div>
            <!-- The Modal -->
            <div class="modal" id="myModal">
              <div class="modal-dialog">
                <div class="modal-content" method="post">
                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title" style="position: absolute; left: 35%">Tạo bài viết
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">
                      &times;
                    </button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">
                    <form method="post">
                    <textarea type="text" name="content" id="post" placeholder="Nhập dữ liệu vào đây!" cols="20"></textarea>
                    <div class="modal-footer">
                      <button  onclick ="reload()" type="submit" class="btn btn-primary">Đăng bài</button>
                    </div>
                  </form>
                  </div>

                  <!-- Modal footer -->
                </div>
              </div>
            </div>
            <?php
            foreach($post as $value){
              echo'
                <div class="mb-2">
                    <div class="media border p-3">
                      <img src="./upload/images.png" class="mr-3 mt-1 rounded-circle" style="width:60px; height:60px;">
                        <div class="media-body">';
                          if($value['Id_ND']==$rs){
                          echo'
                          <div class="dropdown  float-right">
                                <button type="button" class="btn dropdown-toggle " data-toggle="dropdown"></button>
                                <div class="dropdown-menu">
                                  <a href ="editpost.php?id='.$value['Id'].'"><button  class="dropdown-item  ">Chỉnh sửa</button></a>
                                  <button class="dropdown-item" onclick="DelPost('.$value['Id'].')">Xoá</button>
                                </div>
                          </div>';
                          }
                          echo'
                          <h4>'.$value['Ten'].'</h4>
                          <h6><small><i>Ngày đăng: '.$value['NgayTao'].'</i></small></h6>
                          <p style="font-size:30px;">'.$value['NoiDung'].'</p>
                          <div class="cmt">
                          <form  method="post" class="mb-2">
                            <div class="input-group">
                              <input type="text"  name = "cmt" class="form-control" placeholder="Viết bình luận vào đây...">
                              <input type="hidden" name ="id-post" value = "'.$value['Id'].'">
                              <input type="hidden" name ="id-user" value = "'.$rs.'">
                              <div class="input-group-prepend">
                                <button type ="submit" class="btn btn-info ml-1">Đăng</button>
                              </div>
                            </div>
                          </form>';
                        $cmt ="select nguoidung.Ten as Ten,binhluan.NoiDung as NoiDung from binhluan inner join baiviet on binhluan.Id_BV = baiviet.Id inner join nguoidung on binhluan.Id_ND = nguoidung.Id where binhluan.Id_BV = ".$value['Id']." limit 2";
                        $rscmt = executeResult($cmt);
                        foreach($rscmt as $item){
                        echo '
                          <div class="media border p-2 mb-2">
                            <img src="./upload/images.png"  class="mr-3 mt-3 rounded-circle" style="width:60px;">
                              <div class="media-body">
                                <h4>'.$item['Ten'].'</h4>
                                <p>'.$item['NoiDung'].'</p>
                              </div>
                          </div>';
                        }
                        echo'
                          <div>
                            <a href ="detailpost.php?id='.$value['Id'].'"><button class="btn btn-outline-primary">Xem thêm</button></a>
                          </div>
                          </div>
                        </div>
                    </div>
                </div>';
            }
            ?>
          </div>
          <div class="col-md-2" style="background: rgb(141 177 249)"></div>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script> 
  function DelPost(id){
    $.post('api.php',{
        'id': id,
        'action':'delpost'
    },function(data){
        location.reload();
    })
    }       
</script>
<?php
    if(!empty($_POST['content'])){
        $content = getPOST('content');
        $status = 1;
        $created_at = date('Y-m-d');
        if(empty($content)){
            echo"<script>alert('Vui lòng điền đầy đủ thông tin')</script>";
        }
        else{
            $sql="insert into baiviet (Id_ND,NoiDung,NgayTao,TrangThai) values('$rs','$content','$created_at','$status')";
            execute($sql);
            echo"<script>alert('Đăng bài thành công')</script>"; 
            die(); 
        }
    }
    if(!empty($_POST['Id-post'])){
      $id = getPOST('Id-post');
      $sql = "delete from baiviet where Id = '.$id.'";
      execute($sql);
    }
    if(!empty($_POST['cmt'])){
      $content = getPOST('cmt');
      $id_post = getPOST('id-post');
      $id_user = getPOST('id-user');
      if(empty($content)){
          echo"<script>alert('Vui lòng điền đầy đủ thông tin')</script>";
      }
      else{
          $sql="insert into binhluan (Id_BV,Id_ND,NoiDung) values('$id_post','$id_user','$content')";
          execute($sql); 
          die(); 
      }
  }
?>