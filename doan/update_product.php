<?php
// Kết nối đến cơ sở dữ liệu
require('../doan/model/database.php');
require('../doan/model/sanpham_db.php');
require('../doan/model/sanpham.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['idsp']) && isset($_POST['productName']) && isset($_POST['productPrice'])) {
    // Lấy thông tin sản phẩm từ POST request
    $idsp = $_POST['idsp'];
    $productName = $_POST['productName'];
    $productPrice = $_POST['productPrice'];

    // Cập nhật thông tin sản phẩm trong cơ sở dữ liệu
    $sanphamdb = new sanphamdb();
    $sanpham = $sanphamdb->getProductByID($idsp);
    if ($sanpham) {
        $sanpham->setNamesp($productName);
        $sanpham->setPrice($productPrice);
        // Cập nhật thông tin sản phẩm
        $sanphamdb->updateProduct($sanpham);
        // Trở về trang quản lý sản phẩm sau khi cập nhật thành công
        header("Location: admin.php");
        exit();
    } else {
        // Xử lý lỗi nếu không tìm thấy sản phẩm
        echo "Không tìm thấy sản phẩm cần cập nhật.";
    }
} else {
    // Xử lý lỗi nếu không nhận được dữ liệu POST
    echo "Yêu cầu không hợp lệ.";
}
?>
