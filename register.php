<?php
require_once('connection.php');
$errors = array();
$error = '';

print_r($_FILES);
if (isset($_POST['submit'])) {
    $name = $_POST["username"];
    $phone = $_POST["phone"];
    $birthday = $_POST["birthday"];
    $address = $_POST["address"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $repassword = $_POST["repassword"];
    $checkusername = "SELECT * FROM user WHERE UserName = '$name'";
    $is_checkusername = mysqli_query($connection, $checkusername);
    $count_checkusername = mysqli_num_rows($is_checkusername);
    $checkemail = "SELECT * FROM user WHERE Email = '$email'";
    $is_checkemail = mysqli_query($connection, $checkemail);
    $count_checkemail = mysqli_num_rows($is_checkemail);
    // Kiểm tra tên
    if (empty($name)) {
        $errors["name"] = "Tên không được để trống";
        var_dump($errors);
    } else if (strlen($name) < 4) {
        $errors["name"] = "Tên phải có ít nhất 4 ký tự";
    } else if ($count_checkusername > 0) {
        $errors["nameused"] = "Tên đã có người sử dụng";
        var_dump($errors);
    }

    // Kiểm tra số điện thoại
    if (empty($phone)) {
        $errors["phone"] = "Số điện thoại không được để trống";
    } else if (!is_numeric($phone)) {
        $errors["phone"] = "Số điện thoại phải là số";
    } else if (strlen($phone) < 10) {
        $errors["phone"] = "Số điện thoại phải có ít nhất 10 số";
    }

    // Kiểm tra ngày tháng năm sinh
    if (empty($birthday)) {
        $errors["birthday"] = "Ngày tháng năm sinh không được để trống";
    } else {
        $date_arr = explode('/', $birthday);
        if (count($date_arr) != 3 || !checkdate($date_arr[0], $date_arr[1], $date_arr[2])) {
            $errors["birthday"] = "Ngày tháng năm sinh không hợp lệ";
        }
    }

    // Kiểm tra địa chỉ
    if (empty($address)) {
        $errors["address"] = "Địa chỉ không được để trống";
    }

    // Kiểm tra email
    if (empty($email)) {
        $errors["email"] = "Email không được để trống";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Email không hợp lệ";
    } else if ($count_checkemail > 0) {
        $errors["usedemail"] = "Email đã xử dụng";
    }

    // Kiểm tra mật khẩu
    if (empty($password)) {
        $errors["password"] = "Mật khẩu không được để trống";
    } else if (strlen($password) < 3) {
        $errors["password"] = "Mật khẩu phải có ít nhất 3 ký tự";
    }

    // Kiểm tra nhập lại mật khẩu
    if (empty($repassword)) {
        $errors["repassword"] = "Vui lòng nhập lại mật khẩu";
    } else if ($password != $repassword) {
        $errors["repassword"] = "Mật khẩu không giống nhau";
    }

    // Kiểm tra checkbox "Tôi không phải robot"
    if (!isset($_POST['isrobot'])) {
        $errors["isrobot"] = "Vui lòng xác nhận không phải robot";
    }
    // xử lý upload ảnh
    $filenameavatar = '';


    $avatars = $_FILES['avatar']; //mảng 1 chiều
    //  Validate:
    // - File upload phải là ảnh
    // - File upload ko đc lớn hơn 2Mb
    if ($avatars['error'] == 0) {
        // - File upload phải là ảnh:
        // Lấy đuôi file:
        $extension = pathinfo($avatars['name'], PATHINFO_EXTENSION);
        $extension = strtolower($extension);
        //		var_dump($extension);
        $allowed = ['png', 'jpg', 'jpeg', 'gif'];
        if (!in_array($extension, $allowed)) {
            $error = 'File upload phải là ảnh';
        }
        // - File upload ko đc lớn hơn 2Mb
        $size_b = $avatars['size'];
        $size_mb = $size_b / 1024 / 1024;
        if ($size_mb > 2) {
            $error = 'File upload ko đc lớn hơn 2Mb';
        }
    } else {
        $error = 'chưa tải ảnh lên thành công';
    }
    // +Xử lý logic chính chỉ khi ko có lỗi:

    if (empty($error) && empty($errors)) {
        // Xử lý upload file vào thư mục chỉ định
        if ($avatars['error'] == 0) {
            $dir_upload = 'useravata';
            // Tạo thư mục useravata trên bằng code
            //, chỉ tạo khi thư mục chưa tồn tại: file_exists
            if (!file_exists($dir_upload)) {
                mkdir($dir_upload);
            }
            // Tạo ra tên file mang tính duy nhất:
            $filenameavatar = time() . '-' . $avatars['name'];

            // Tải file từ thư mục tạm vào thư mục chỉ định:
            $is_upload = move_uploaded_file(
                $avatars['tmp_name'],
                "$dir_upload/$filenameavatar"
            );
        }
    }
    // thực hiện upload lên database
    if (empty($error) && empty($errors)) {
        $name = htmlspecialchars($name);
        $phone = htmlspecialchars($phone);
        $birthday = htmlspecialchars($birthday);
        $address = htmlspecialchars($address);
        $email = htmlspecialchars($email);
        $password = htmlspecialchars($password);
        //  Viết truy vấn SQL:
        $sql_insert = "INSERT INTO user(UserName, PhoneNumber, BirthDay, Address, Email, Password, Avata) VALUES('$name', '$phone', '$birthday', '$address', '$email', '$password', '$filenameavatar')";
        // + Thực thi truy vấn: UPDATE trả về boolean
        $is_insert = mysqli_query($connection, $sql_insert);
        header('Location: profile.html');
        exit();
    }
}
var_dump($error);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <!-- Import Bootstrap and JQuery -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
        integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
                        <a href="index.html" target="_blank"><img src="img/logo.png" alt="img/logo.png"
                                title="Trang Chủ" class="img-fluid"></a>
                        <div class="text">
                            <p>Giúp Bạn Thiết kế web <br> Giúp bạn có Sức Khoẻ và Vóc Dáng Như ý</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12 form bg-r">
                        <form id="register" method="post" enctype="multipart/form-data">
                            <h3>Đăng Ký</h3>
                            <div>
                                <label for="name">Tên Đăng nhập của bạn:</label>
                                <input type="text" class="form-control" id="name" placeholder="Enter name"
                                    value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>"
                                    name="username">
                                <label id="name-error" class="error"
                                    for="name"><?php echo isset($errors["nameused"]) ? $errors["nameused"] : ''; ?></label>

                            </div>
                            <div>
                                <label for="phone">Số điện thoại:</label>
                                <input type="text" class="form-control"
                                    value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>" id="phone"
                                    placeholder="Enter phone" name="phone">
                            </div>
                            <div>
                                <label for="birthday">Ngày tháng nắm sinh:</label>
                                <input type="text" class="form-control"
                                    value="<?php echo isset($_POST['birthday']) ? $_POST['birthday'] : ''; ?>"
                                    id="birthday" placeholder="ngày/tháng/năm" name="birthday">
                            </div>
                            <div>
                                <label for="address">Địa chỉ:</label>
                                <input type="text" class="form-control"
                                    value="<?php echo isset($_POST['address']) ? $_POST['address'] : ''; ?>"
                                    id="address" placeholder="Enter address" name="address">

                            </div>
                            <div>
                                <label for="email">Email address</label>
                                <input type="text" class="form-control"
                                    value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" id="email"
                                    placeholder="Enter email" name="email">
                                <label id="name-error" class="error"
                                    for="name"><?php echo isset($errors["usedemail"]) ? $errors["usedemail"] : ''; ?></label>

                            </div>
                            <div>
                                <label for="password" class="label">Password</label>
                                <input type="password" class="form-control" id="password" placeholder="Password"
                                    name="password">
                            </div>
                            <div>
                                <label for="repassword" class="label">RePassword</label>
                                <input type="password" class="form-control" id="repassword" placeholder="RePassword"
                                    name="repassword">
                            </div>
                            <div>
                                <label for="avatar" class="label">avatar</label>
                                <input type="file" id="avatar" name="avatar">
                                <label id="name-error" class="error"
                                    for="avatar"><?php echo empty($error) ? '' : $error; ?></label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input"
                                    <?php echo isset($_POST['isrobot']) ? "checked" : ''; ?> name="isrobot">
                                <input type="checkbox" class="form-check-input"
                                    <?php echo isset($_POST['isrobot']) ? "checked" : ''; ?> name="isrobot">
                                <label class="form-check-label" for="rememberMe" id="isrobot">Tôi không phải
                                    Robot</label>
                            </div>
                            <button type="submit" class="btn btn-success btn-block my-3" name="submit"
                                value="tải lên">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>