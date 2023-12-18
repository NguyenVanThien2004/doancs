<?php
// Kết nối đến cơ sở dữ liệu
require('../doan/model/database.php');
require('../doan/model/sanpham_db.php'); // Import file sanpham_db.php để sử dụng model sản phẩm
require('../doan/model/sanpham.php');

if (isset($_GET['idsp'])) {
    $sanphamdb = new sanphamdb();
    $product = $sanphamdb->getProductbyid($_GET['idsp']); // Hàm getProductbyid() lấy thông tin sản phẩm dựa trên idsp

    if ($product) {
        // Chuyển đổi thông tin sản phẩm thành mảng
        $productData = array(
            'idsp' => $product->getIdsp(),
            'loaisp' => $product->getloai(),
            'tensp' => $product->getNamesp(),
            'mota' => $product->getCode(),
            'gia' => $product->getPrice(),
            'hinhanh' => $product->getImageAltText()
        );

        // Trả về dữ liệu sản phẩm dưới dạng JSON
        header('Content-Type: application/json');
        echo json_encode($productData);
    } else {
        // Trả về null nếu không tìm thấy sản phẩm
        echo json_encode(null);
    }
}
?>
