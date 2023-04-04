<?php session_start();
require_once('connection.php');
$action = 1;
$home = '';
$person = '';
$calo = '';
if (isset($_COOKIE['email'])) {
    //Tạo session để đánh dấu login thành công
    $_SESSION['email'] = $_COOKIE['email'];
}
$email = $_SESSION['email'];
$dataUserName = "SELECT * FROM user WHERE Email = '$email'";
$pulldata = mysqli_query($connection, $dataUserName);
$showdata = mysqli_fetch_assoc($pulldata);

if (mysqli_num_rows($pulldata) > 0) {


    $name = $showdata["UserName"];
}
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}
switch ($action) {
    case 0:
        $home = 'active';
        break;
    case 1:
        $person = 'active';
        break;
    case 2:
        $calo = 'active';
        break;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="js/index.js" defer></script>
    <title>Trang Chủ</title>
</head>

<body>
    <video autoplay muted loop id="bg-video">
        <source src="video/video_grass.mp4" type="video/mp4">

    </video>
    <header>
        <div class="container-fluid header">
            <div class="row d-flex justify-content-between">
                <div class="header_logo">
                    <img src="img/logo.png" alt="img/logo.png" class="img-fluid">
                </div>
                <div class="header_menber" style="display: <?php echo isset($_SESSION['email']) ? "none" : "flex"; ?>;">
                    <a href="login.php" class="header_menber-button" target="_blank">Đăng nhập thành viên</a>
                    <a href="register.php" class="header_menber-button" target="_blank">Đăng ký thành viên</a>
                </div>
                <div class="header_menber" style="display: <?php echo isset($_SESSION['email']) ? "flex" : "none"; ?>;">

                    <a href="profile.php" class="header_menber-button" target="_blank">Xin Chào
                        <?php echo isset($_SESSION['email']) ? $name : ''; ?> <a href="logout.php">Logout</a></a>
                </div>
            </div>
        </div>
        <ul class="nav " id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link <?php echo $home; ?> border-tree" id="home-tab" data-toggle="tab" href="#home"
                    role="tab" aria-controls="home" aria-selected="true">
                    <img src="img/day_leo.png" alt="" class="img-fluid">
                    <img src="img/day_leo_2.png" alt="" class="img-fluid">
                    <img src="img/day_leo.png" alt="" class="img-fluid">
                    <img src="img/day_leo_2.png" alt="" class="img-fluid">
                    Trang Chủ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $person; ?> border-tree" id="profile-tab" data-toggle="tab"
                    href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                    <img src="img/day_leo.png" alt="" class="img-fluid">
                    <img src="img/day_leo_2.png" alt="" class="img-fluid">
                    <img src="img/day_leo.png" alt="" class="img-fluid">
                    <img src="img/day_leo_2.png" alt="" class="img-fluid">Giới Thiệu Bản Thân</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link <?php echo $calo; ?> border-tree" id="calculate-tab" data-toggle="tab"
                    href="#calculate" role="tab" aria-controls="calculate" aria-selected="false">
                    <img src="img/day_leo.png" alt="" class="img-fluid">
                    <img src="img/day_leo_2.png" alt="" class="img-fluid">
                    <img src="img/day_leo.png" alt="" class="img-fluid">
                    <img src="img/day_leo_2.png" alt="" class="img-fluid">Tính Calo</a>
            </li>
        </ul>
    </header>
    <main>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade ml-5 content" id="home" role="tabpanel" aria-labelledby="home-tab">.ád.</div>
            <div class="tab-pane fade show active ml-5 content" id="profile" role="tabpanel"
                aria-labelledby="profile-tab">
                <div class="container">
                    <div class="row">
                        <div class="col-md-9">
                            <h3>Xin Chào!!!</h3>
                            <h1>Tôi Là Tăng Xuân Anh, một người lập trình web</h1>
                            <p>Tôi có kỹ năng về: <i class="fa-brands fa-html5" style="color: #DD4A28;"></i> HTML, <i
                                    style="color: #1572B6;" class="fab fa-css3"></i>
                                CSS, <i class="fab fa-js" style="color: yellow;"></i> JS, <i class="fab fa-php"></i> PHP
                            </p>
                            <p>Thư viện sử dụng: Bootstrap, Jquery, Fontawesome...</p>
                            <p>Ngày Sinh: 04/12/1995</p>
                            <p>Địa chỉ : Thượng Thanh, Long biên Hà Nội</p>
                            <p>Số Điện Thoại: 0389607406</p>
                            <p>Email: tangxuananh1995@gmail.com</p>
                            <p>Tôi là một người đam mê về công nghệ , nó bắt đầu đầu khi tôi tiếp xúc với máy tính. Tôi
                                luôn có câu hỏi tại sao máy tính hoạt động được như vậy và luôn sợ mình thụt lùi so với
                                thời đại, điều đó thôi thúc tôi tìm tòi, học hỏi về công nghê. Sau 1 thời gian đi làm
                                tôi thấy là web giúp ích và tiếp cận dễ dàng với rất nhiều người tại thời điểm hiện tại.
                                Nên tôi đã đi học làm web để tạo ra nhiều giá trị hơn, tiếp cận được nhiều người hơn</p>
                            <div class="text-center">
                                <a href="https://www.topcv.vn/xem-cv/X1RXUldZXloHAlAEA1FTAFFSU1MBWwNQVgIBAgda4f"
                                    class="cv" target="_blank">Link CV</a>

                            </div>
                        </div>
                        <div class="col-md-3 side-bar">
                            <img src="img/avata.jpg" title="avata" class="img-fluid" alt="img/avata.jpg">
                            <br>
                            <a href="https://www.facebook.com/bach.t.vuong"> <i class="fab fa-facebook"></i>
                                FaceBook</a>
                            <br>
                            <a href="https://www.youtube.com/channel/UCdWP4f3gZTNPc4VzciBeNZg"> <i
                                    class="fab fa-youtube"></i> Youtube</a>
                            <br>
                            <a href="https://discord.com/users/626596989131423774"> <i
                                    class="fab fa-discord"></i>Discord</a>
                            <br>
                            <a href="https://goo.gl/maps/F6v7WWxgv3KRiVKA6" target="_blank"> <i
                                    class="fas fa-location-arrow"></i>Address</a>

                        </div>

                    </div>

                </div>
            </div>
            <div class="tab-pane fade ml-5 content" id="calculate" role="tabpanel" aria-labelledby="calculate-tab">..d.
            </div>
        </div>

    </main>
    <footer>
        <div class="footer text-center">Copyright 2023 Tăng Xuân Anh</div>
    </footer>
</body>

</html>