<?php
session_start();

if (isset($_POST['key'])) {
    $key = $_POST['key'];
    if (isset($_SESSION['cart'][$key])) {
        unset($_SESSION['cart'][$key]);
    }

    // Tính lại tổng số tiền sau khi xóa sản phẩm
    $totalAmount = 0;
    foreach ($_SESSION['cart'] as $cartItem) {
        $price = str_replace(',', '', $cartItem['price']);
        $price = floatval($price);
        $totalAmount += ($price * $cartItem['quantity']);
    }

    echo $totalAmount;
} else {
    echo 'error';
}
?>