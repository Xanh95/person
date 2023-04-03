<?php session_start();
require_once('connection.php');
if (!isset($_SESSION['username'])) {
    header('location: login.php');
    $_SESSION['error'] = 'Bạn Chưa Đăng Nhập';
}
$username = $_SESSION['username'];
$dataUserName = "SELECT * FROM user WHERE UserName = '$username'";
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
    switch ($showdata["Gender"]) {
        case 0:
            $gender = 'Nam';
            break;
        case 1:
            $gender = 'Nữ';
            break;
    }
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
    <style>
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

        a {
            text-decoration: none;
            color: white;
        }

        a:hover {
            color: white;
        }
    </style>
</head>

<body className='snippet-body'>
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="./useravata/<?php echo $avatar; ?>"><span class="font-weight-bold"><?php echo $username; ?></span><span class="text-black-50"><?php echo $email; ?></span><span> </span></div>
            </div>
            <div class="col-md-5 border-right">
                <div class="p-3 py-5">
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
                        <a class="btn btn-primary profile-button" href="index.html">Trang Chủ</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
    </div>
    <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js'></script>


</body>

</html>