<?php 
  echo '<pre>'; 
  print_r($_POST);
  print_r($_FILES);
  echo '</pre>'; 
if (isset($_POST['submit'])) {
    $avatar = $_FILES['avatar'];
    $error = false;
    if ($avatar['error'] == 0 ) {
        $extension = pathinfo($avatar['name'], PATHINFO_EXTENSION);
        $extension = strtolower($extension);
        $allowed = ['png', 'jpg', 'jpeg', 'gif'];
        if (!in_array($extension, $allowed)) {
            $error = true;
        }
        $size_b = $avatar['size'];
        $size_mb = $size_b/ 1024 / 1024;
        if ($size_mb > 2) {
            $error = true;
        }
    }
    if (!$error) {
        $filename = '';
        if ($avatar['error'] == 0) {
            $dir_upload = 'upload';
            if (!file_exists($dir_upload)) {
                mkdir($dir_upload);
            }
            $filename = time() . '-' . $avatar['name'];
            $is_upload = move_uploaded_file($avatar['tmp_name'],"$dir_upload/$filename");
            echo "<img src='$dir_upload/$filename' height='50px' >";
        }
    }

}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Register</title>	
  <!-- Import Bootstrap and JQuery -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>        
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>   
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <!-- My CSS and JQuery -->
  <link href="css/register.css" rel="stylesheet">
  <script type="text/javascript" src="js/register.js" defer></script> 
</head>
<body>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-6 col-sm-12 col-xs-12 row-container bg">
        <div class="row ">
            <div class="col-md-6 bg-l text-center">
                <a href="index.html" target="_blank"><img src="img/logo.png" alt="img/logo.png" title="Trang Chủ" class="img-fluid"></a>
                <div class="text">
                  <p>Giúp Bạn Thiết kế web <br> Giúp bạn có Sức Khoẻ và Vóc Dáng Như ý</p>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 form bg-r">
                <form id="login" method="post" enctype="multipart/form-data">
                  <h3>Đăng Ký</h3>
                  <div>
                    <label for="name">Tên của bạn:</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
                  </div>
                  <div>
                    <label for="phone">Số điện thoại:</label>
                    <input type="text" class="form-control" id="phone" placeholder="Enter phone" name="phone">
                  </div>
                  <div>
                    <label for="birthday">Ngày tháng nắm sinh:</label>
                    <input type="text" class="form-control" id="birthday" placeholder="tháng/ngày/năm" name="birthday">
                  </div>
                  <div >
                    <label for="address">Địa chỉ:</label>
                    <input type="text" class="form-control" id="address" placeholder="Enter address" name="address">
                   
                  </div>
                  <div >
                    <label for="email">Email address</label>
                    <input type="text" class="form-control" id="email" placeholder="Enter email" name="email">
                   
                  </div>
                  <div >
                    <label for="password" class="label">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Password" name="password">            
                  </div>
                  <div >
                    <label for="repassword" class="label">RePassword</label>
                    <input type="password" class="form-control" id="repassword" placeholder="RePassword" name="repassword">            
                  </div>
                  <div >
                    <label for="avatar" class="label">avatar</label>
                    <input type="file"  id="avatar" name="avatar">            
                  </div>
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="rememberMe" name="isrobot">
                    <label class="form-check-label" for="rememberMe"  id="isrobot">Tôi không phải Robot</label>
                  </div>   
                  <button type="submit" class="btn btn-success btn-block my-3" name="submit" value="tải lên">Register</button>
                </form>
            </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>	