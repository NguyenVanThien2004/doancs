<?php
session_start();

// Kiểm tra yêu cầu POST và tồn tại SESSION 'cart'
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['cart'])) {
    $totalAmount = 0;

    // Tính toán lại totalAmount từ SESSION 'cart'
    foreach ($_SESSION['cart'] as $cartItem) {
        if (isset($cartItem['name'], $cartItem['price'], $cartItem['quantity'])) {
            $price = str_replace(',', '', $cartItem['price']);
            $price = floatval($price);
            $totalAmount += ($price * $cartItem['quantity']);
        }
    }

    // Cập nhật totalAmount trên server
    // Ví dụ: Lưu totalAmount vào cơ sở dữ liệu hoặc thực hiện các thao tác khác

    // Trả về totalAmount đã được cập nhật
    echo $totalAmount;
}
?>