<?php session_start();
require_once('connection.php');
if (!isset($_SESSION['email'])) {
    header('location: login.php');
    $_SESSION['error'] = 'Bạn Chưa Đăng Nhập';
}
$email = $_SESSION['email'];
$dataUserName = "SELECT * FROM user WHERE Email = '$email'";
$pulldata = mysqli_query($connection, $dataUserName);
$showdata = mysqli_fetch_assoc($pulldata);

if (mysqli_num_rows($pulldata) > 0) {


    $name = $showdata["UserName"];
    $phone = $showdata["PhoneNumber"];
    $birthday = $showdata["BirthDay"];
    $address = $showdata["Address"];
    $email = $showdata["Email"];
    $avatar = $showdata["Avata"];
    $gender = '';
}
$edit = false;
$checked_male = '';
$checked_female = '';
if (isset($_POST['edit'])) {
    $edit = true;
    switch ($showdata["Gender"]) {
        case 0:
            $checked_male = 'checked';
            break;
        case 1:
            $checked_female = 'checked';
            break;
    }
    if (isset($_SESSION['success'])) {
        unset($_SESSION['success']);
    }
}

$errors = array();
$error = '';

if (isset($_POST['save'])) {
    $name = $_POST["username"];
    $phone = $_POST["phone"];
    $birthday = $_POST["birthday"];
    $address = $_POST["address"];

    $password = $_POST["password"];
    $repassword = $_POST["repassword"];
    $checkusername = "SELECT * FROM user WHERE UserName = '$name'";
    $is_checkusername = mysqli_query($connection, $checkusername);
    $count_checkusername = mysqli_num_rows($is_checkusername);
    // Kiểm tra tên
    if (empty($name)) {
        $errors["name"] = "Tên không được để trống";
    } else if (strlen($name) < 4) {
        $errors["name"] = "Tên phải có ít nhất 4 ký tự";
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
    }

    // Kiểm tra địa chỉ
    if (empty($address)) {
        $errors["address"] = "Địa chỉ không được để trống";
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


    // kiểm tra giới tính
    if (!isset($_POST['gender'])) {
        $errors["gender"] = "Xin chọn giới tính";
    }





    // xử lý upload ảnh



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


            // Tải file từ thư mục tạm vào thư mục chỉ định:
            $is_upload = move_uploaded_file(
                $avatars['tmp_name'],
                "$dir_upload/$avatar"
            );
        }
    }
    if (!empty($errors)) {
        $edit = true;
        switch ($showdata["Gender"]) {
            case 0:
                $checked_male = 'checked';
                break;
            case 1:
                $checked_female = 'checked';
                break;
        }
    }
    // thực hiện upload lên database
    if (empty($errors)) {
        $name = htmlspecialchars($name);
        $phone = htmlspecialchars($phone);
        $birthday = htmlspecialchars($birthday);
        $address = htmlspecialchars($address);
        $email = htmlspecialchars($email);
        $password = htmlspecialchars($password);
        $gender = htmlspecialchars($_POST['gender']);
        $name = mysqli_real_escape_string($connection, $name);
        $phone = mysqli_real_escape_string($connection, $phone);
        $birthday = mysqli_real_escape_string($connection, $birthday);
        $address = mysqli_real_escape_string($connection, $address);
        $email = mysqli_real_escape_string($connection, $email);
        $password = mysqli_real_escape_string($connection, $password);
        $gender = mysqli_real_escape_string($connection, $_POST['gender']);
        //  Viết truy vấn SQL:
        $sql_update = "UPDATE user SET UserName = '$name', PhoneNumber = '$phone', BirthDay = '$birthday', Address = '$address', Password = '$password', Gender = '$gender' WHERE Email = '$email'";
        var_dump($sql_update);
        // + Thực thi truy vấn: UPDATE trả về boolean
        $is_update = mysqli_query($connection, $sql_update);


        header('Location: profile.php');
        exit();
    }
}
switch ($showdata["Gender"]) {
    case 0:
        $gender = 'Nam';
        break;
    case 1:
        $gender = 'Nữ';
        break;
}


?>
<!doctype html>
<html>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>profile</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='#' rel='stylesheet'>
    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script type="text/javascript" src="./js/editprofile.js" defer></script>
    <style>
        #avatar {
            margin-top: 5px;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #888;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        body {
            background: rgb(122, 238, 147)
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #68c875
        }

        .profile-button {
            background: rgb(92, 247, 78);
            box-shadow: none;
            border: none
        }

        .profile-button:hover {
            background: green
        }

        .profile-button:focus {
            background: green;
            box-shadow: none
        }

        .profile-button:active {
            background: green;
            box-shadow: none
        }

        .back:hover {
            color: green;
            cursor: pointer
        }

        .labels {
            font-size: 11px
        }

        .logout {
            text-decoration: none;
            color: white;
        }

        .logout:hover {
            color: white;
        }

        .edit {
            margin-bottom: 10px;
        }
    </style>
</head>

<body className='snippet-body'>
    <form action="" method="post" enctype="multipart/form-data" id="editprofile">
        <div class="container rounded bg-white mt-5 mb-5">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                        <img class="rounded-circle mt-5" width="150px" src="./useravata/<?php echo $avatar; ?>">

                        <span class="font-weight-bold"><?php echo $name; ?></span><span class="text-black-50"><?php echo $email; ?></span><span> </span>
                    </div>
                    <h5 style="color: #68c875;"><?php echo isset($_SESSION['success']) ?  $_SESSION['success'] : ''; ?>
                    </h5>
                    <div class="edit text-center">
                        <?php if ($edit === true) : ?>
                            <button type="submit" class="btn btn-primary profile-button logout" name="save">Save</button>
                            <button type="submit" class="btn btn-primary profile-button logout" name="cancel">Cancel</button>
                        <?php else : ?>
                            <button type="submit" class="btn btn-primary profile-button logout" name="edit">Edit</button>
                        <?php endif; ?>


                    </div>
                </div>
                <div class="col-md-5 border-right">
                    <div class="p-3 py-5" style="display: <?php echo $edit ? 'none' : 'block' ?>;">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Thông tin Cá Nhân</h4>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12"> <?php echo "Số Điện Thoại: $phone" ?></div>
                            <div class="col-md-12"><?php echo "Ngày Sinh : $birthday" ?></div>
                            <div class="col-md-12"><?php echo "Địa Chỉ:  $address" ?></div>
                            <div class="col-md-12"><?php echo "Giới Tính: $gender" ?></div>
                        </div>
                        <div class="mt-5 text-center">
                            <a class="btn btn-primary profile-button logout" href="logout.php">Log Out</a>
                        </div>
                    </div>
                    <?php echo ($edit ? '<h3>Thay đổi Thông tin</h3>
                            <div>
                                <label for="name">Tên của bạn:</label>
                                <input type="text" class="form-control" id="name" placeholder="Enter name"
                                    value="' . ($name) . '"
                                    name="username">
                                <label id="name-error" class="error"
                                    for="name">' . (isset($errors["nameused"]) ? $errors["nameused"] : '') . '</label>

                            </div>
                            <div>
                                <label for="phone">Số điện thoại:</label>
                                <input type="text" class="form-control"
                                    value="' . ($phone) . '" id="phone"
                                    placeholder="Enter phone" name="phone">
                            </div>
                            <div>
                                <label for="birthday">Ngày tháng nắm sinh:</label>
                                <input type="text" class="form-control"
                                    value="' . ($birthday) . '"
                                    id="birthday" placeholder="ngày/tháng/năm" name="birthday">
                            </div>
                            <div>
                                <label for="address">Địa chỉ:</label>
                                <input type="text" class="form-control"
                                    value="' . ($address) . '"
                                    id="address" placeholder="Enter address" name="address">

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
                                <label id="name-error" class="error">' . (empty($error) ? '' : $error) . '</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" ' . $checked_male . ' name="gender"
                                    value="0"> Nam
                                <input class="gender" type="radio" class="form-check-input"
                                    ' . $checked_female . ' name="gender" value="1">Nữ
                                <p class="error">' . (isset($error['gender']) ? $error['gender'] : '') . '</p>
                            </div>
                            ' : ''); ?>

                </div>
                <div class="col-md-4">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="index.php?action=2">tính
                                calo
                            </a>
                        </div>
                        <h5 style="color: red;">
                            <?php
                            foreach ($errors as $value) {
                                echo $value;
                            }
                            ?>
                        </h5>
                    </div>

                </div>
            </div>
        </div>
        </div>
        <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js'></script>

    </form>
</body>

</html>