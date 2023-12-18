<?php
class Session {
    public static function start() {
        session_start();
    }

    public static function setUser($user) {
        $_SESSION['user'] = $user;
    }

    public static function getUser() {
        return $_SESSION['user'];
    }
}
Session::start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    // Xử lý đăng nhập

    // Lấy thông tin người dùng từ dữ liệu đăng nhập
    $username = $_POST['username'];
    $password = $_POST['password'];
}
?>