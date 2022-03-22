<?php
    session_start();
    require_once('./utils/utility.php');
    require_once('./database/dbhelper.php');
    $key = getPOST('search');
    $user = getToken();
    $role = $user['Role'];
    $rs = $user['Id'];
    $sql1 = "select user.* from user where id ='$rs'";
    $data = executeResult($sql1);
    $qr = "select User.*,post.* from post inner join user on post.User_id = User.Id where Post.Status = 1  and Post.Content like '%$key%'";
    $post = executeResult($qr);
    $qr1 = "select count(*) as total from post where Content like '%$key%' "; 
    $count = executeResult($qr1);
    
    foreach($count as $value){
      $sl = $value['total'];
    }
    if (strtolower($role) == 'admin'){
        require_once('./layoutAdmin/header.php');
    }
    else
        require_once('./layout/header.php');
?>
<div class="row" style="min-height:200vh;">
    <div class="col-md-3" style="background: rgb(141 177 249)"></div>
    <div class="col-md-7" style="background: rgb(244 245 247)">
        <?php
            if($sl>0){
            foreach($post as $value){
              echo'
                <div class="mb-2">
                    <div class="media border p-3">
                      <img src="./upload/images.png" class="mr-3 mt-1 rounded-circle" style="width:60px; height:60px;">
                        <div class="media-body">
                          <h4>'.$value['Name'].'</h4>
                          <h6><small><i>Ngày đăng: '.$value['Created_at'].'</i></small></h6>
                          <p style="font-size:30px;">'.$value['Content'].'</p>
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
                        $cmt ="select user.Name as name,comments.Content as content from comments inner join post on comments.Id_post = post.Id inner join user on comments.Id_user = user.Id where comments.Id_post = ".$value['Id']." limit 2";
                        $rscmt = executeResult($cmt);
                        foreach($rscmt as $item){
                        echo '
                          <div class="media border p-2 mb-2">
                            <img src="./upload/images.png"  class="mr-3 mt-3 rounded-circle" style="width:60px;">
                              <div class="media-body">
                                <h4>'.$item['name'].'</h4>
                                <p>'.$item['content'].'</p>
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
            }}
            else{
              echo'<h1>Không có kết quả nào!</h1>';
            }
            ?>
          </div>
          <div class="col-md-2" style="background: rgb(141 177 249);"></div>
        </div>
