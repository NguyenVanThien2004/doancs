
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
  input[type="email"],
  input[type="password"] {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border: none;
    border-radius: 4px;
    background-color: #f5f5f5;
  }

  input[type="text"]:focus,
  input[type="email"]:focus,
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
    <h2>ĐĂNG KÝ</h2>
    <form action="regist.php" method="POST">
      <input type="text" name="username" placeholder="Username">
      <input type="email" name="email" placeholder="Email">
      <input type="password" name="password" placeholder="Password">
      <button type="submit" name="regist_user">Đăng Ký</button>
      <p>Đã có tài khoản? <a href="login.php">Đăng nhập tại đây!</a></p>
    </form>
  </body>
  </html>
<?php
   session_start(); // Khởi động session

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
  $errors = array(); // Mảng để lưu trữ các lỗi

  if (isset($_POST['regist_user'])) {
      // Kiểm tra và lấy giá trị từ các trường nhập liệu
      if (empty($_POST['username'])) {
          $errors[] = "Vui lòng nhập tên đăng nhập.";
      } else {
          $username = $_POST['username'];
          $user->setName($username);
      }

      if (empty($_POST['email'])) {
          $errors[] = "Vui lòng nhập địa chỉ email.";
      } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
          $errors[] = "Địa chỉ email không hợp lệ.";
      } else {
          $email = $_POST['email'];
          $user->setEmail($email);
      }

      if (empty($_POST['password'])) {
          $errors[] = "Vui lòng nhập mật khẩu.";
      } else {
          $password = $_POST['password'];
          $user->setPassword(password_hash($password, PASSWORD_DEFAULT)); // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
      }

      // Nếu không có lỗi, thực hiện thêm người dùng vào cơ sở dữ liệu và khởi tạo session
      if (empty($errors)) {
          $stmt = $db->prepare('INSERT INTO user (username, password, email) VALUES (?, ?, ?)');
          $stmt->execute([$user->getName(), $user->getPassword(), $user->getEmail()]);

          // Lưu thông tin người dùng vào session
          $_SESSION['user_id'] = $user->getId(); // Giả sử bạn có phương thức getId() để lấy ID của người dùng
          $_SESSION['username'] = $user->getName();

          $user_id = $db->lastInsertId();
          $user->setId($user_id);

          // Gán giá trị ID cho đối tượng $user
          $user->setId($user_id);
          $stmt = $db->prepare('INSERT INTO cart (user_id) VALUES (?)');
          $stmt->execute([$user_id]);

          // Chuyển hướng đến trang index1.php
          header("Location: index1.php");
          exit; // Chắc chắn kết thúc quá trình thực thi mã
      } else {
          $errorMessages = implode("\\n", $errors); // Tạo chuỗi thông báo lỗi
          echo "<script>alert('$errorMessages');</script>"; // Hiển thị thông báo lỗi bằng JavaScript
      }
  }
  ?>
 