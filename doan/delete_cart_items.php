<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        if (isset($_POST['key'])) {
            $key = $_POST['key'];

            if (isset($_SESSION['cart'][$key])) {
                unset($_SESSION['cart'][$key]); // Xóa sản phẩm khỏi giỏ hàng theo key
                
                // Cập nhật lại session sau khi xóa
                $_SESSION['cart'] = array_values($_SESSION['cart']);
                
                echo 'success'; // Trả về success nếu xóa thành công
                exit();
            }
        }
    }
}

echo 'error'; // Trả về error nếu có lỗi trong quá trình xóa
?>
