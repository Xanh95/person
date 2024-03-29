<?php session_start();
require_once('connection.php');
if (isset($_COOKIE['email'])) {
    //Tạo session để đánh dấu login thành công
    $_SESSION['email'] = $_COOKIE['email'];
    header('Location: profile.php');
    exit();
}
$error = '';
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (empty($email) || empty($password)) {
        $error = 'phải nhập đầy đủ email và password';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'email không đúng định dạng';
    }
    if (empty($error)) {
        $sql_login = "SELECT * FROM user WHERE Email = '$email' AND Password = '$password'";
        $is_login = mysqli_query($connection, $sql_login);
        if (mysqli_num_rows($is_login) > 0) {
            $_SESSION['email'] = $email;
            if (isset($_POST['remember'])) {
                $_SESSION['success'] = 'Ghi nhớ đăng nhập thành công';

                setcookie('email', $email, time() + 3600);
            }
        } else {
            $error = 'sai email hoặc mật khẩu';
        }
    }
}
if (isset($_SESSION['email'])) {

    header('Location: profile.php');
    exit();
}
if (isset($_SESSION['success'])) {
    $error = $_SESSION['success'];
    unset($_SESSION['success']);
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
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
    <link href="css/login.css" rel="stylesheet">
    <script type="text/javascript" src="js/login.js" defer></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-12 col-xs-12 row-container bg">
                <div class="row ">
                    <div class="col-md-6 bg-l text-center">
                        <a href="index.php" target="_blank"><img src="img/logo.png" alt="img/logo.png" title="Trang Chủ"
                                class="img-fluid"></a>
                        <div class="text">
                            <p>Giúp Bạn Thiết kế web <br> Giúp bạn có Sức Khoẻ và Vóc Dáng Như ý</p>
                            <h3 style="color: red;"><?php echo "$error" ?></h3>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12 form bg-r">
                        <form id="login" method="post" action="">
                            <h3>Đăng Nhập</h3>
                            <div>
                                <label for="email">Email address</label>
                                <input type="text" class="form-control" id="email" placeholder="Enter email"
                                    name="email">

                            </div>
                            <div>
                                <label for="password" class="label">Password</label>
                                <input type="password" class="form-control" id="password" placeholder="Password"
                                    name="password">

                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="rememberMe" name="remember">
                                <label class="form-check-label" for="rememberMe" id="remember">Ghi Nhớ Đăng Nhập
                                </label>
                                <a href="register.php">Đăng ký</a>
                            </div>
                            <button type="submit" class="btn btn-success btn-block my-3" name="login">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>