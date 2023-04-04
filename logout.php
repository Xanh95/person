<?php
session_start();
//logout.php
// Xóa session sinh ra khi login thành công
unset($_SESSION['email']);

//Xóa cookie ghi nhớ đăng nhập
setcookie('email', '', time() - 1);

$_SESSION['success'] = 'Đăng xuất thành công';
header('Location: login.php');
exit();
