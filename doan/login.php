<?php
session_start();
require('../doan/model/database.php');
require('../doan/model/category.php');
require('../doan/model/sanpham.php');
require('../doan/model/sanpham_db.php');
require('../doan/model/category_db.php');
require('../doan/model/sanphamcon_db.php');
require('../doan/model/sanphamcon.php');
require('../doan/model/user.php');

$db = Database::getDB();
$user = new User();

if (isset($_POST['login_user'])) {
  // Kiểm tra và lấy giá trị từ các trường nhập liệu
  if (empty($_POST['username'])) {
    $errors[] = "Vui lòng nhập tên đăng nhập.";
  } else {
    $username = $_POST['username'];
  }

  if (empty($_POST['password'])) {
    $errors[] = "Vui lòng nhập mật khẩu.";
  } else {
    $password = $_POST['password'];
  }

  // Kiểm tra thông tin đăng nhập
  $stmt = $db->prepare('SELECT * FROM user WHERE username = ?');
  $stmt->execute([$username]);
  $user = $stmt->fetch();
  
  if ($user && password_verify($password, $user['password'])) {
    // Đăng nhập thành công
    $_SESSION['username'] = $username;
    $_SESSION['loggedIn'] = true;
  
    // Chuyển hướng người dùng đến trang chính hoặc trang khác
    header('Location: index1.php');
    exit;
  } else {
    // Đăng nhập không thành công
    $errors[] = 'Tên đăng nhập hoặc mật khẩu không chính xác.';
  }

  // Hiển thị thông báo lỗi nếu có
  if (!empty($errors)) {
    $errorMessages = implode("\\n", $errors); // Tạo chuỗi thông báo lỗi
    echo "<script>alert('$errorMessages');</script>"; // Hiển thị thông báo lỗi bằng JavaScript
  }
}

?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f1f1f1;
    }

    form {
      max-width: 400px;
      margin: 0 auto;
      background-color: #fff;
      padding: 20px;
      margin-top: 50px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border: none;
      border-radius: 4px;
      background-color: #f5f5f5;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
      background-color: #e8e8e8;
    }

    button[type="submit"] {
      background-color: #333;
      color: #fff;
      padding: 12px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    h2 {
      padding-top: 40px;
      text-align: center;
      color: #333;
      margin-bottom: 20px;
      font-size: 24px;
      text-transform: uppercase;
      letter-spacing: 2px;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
      font-size: 35px;
    }

    button[type="submit"]:hover {
      background-color: #555;
    }
  </style>

</head>
<body>
  <h2>ĐĂNG NHẬP</h2>
  <form action="login.php" method="POST">
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="password" placeholder="Password">
    <button type="submit" name="login_user">Đăng Nhập</button>
    <p>Chưa có tài khoản? <a href="regist.php">Đăng ký ngay!</a></p>
  </form>
</body>

</html>