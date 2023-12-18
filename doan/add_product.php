<?php

require('../doan/model/database.php');
require('../doan/model/sanpham_db.php');
require('../doan/model/sanpham.php');
require('../doan/model/admin.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['productName'])) {
        $sanpham->setNamesp($_POST['productName']);
    }

    // Kiểm tra và xử lý file ảnh
    if (isset($_FILES['productImage'])) {
        $hinhanh = $_FILES['productImage']['name']; // 
        $sanpham->setImageAltText($hinhanh);
        $targetDirectory = "../image/"; // Thay đổi đường dẫn thư mục lưu trữ file ảnh
        $targetFile = $targetDirectory . basename($_FILES["productImage"]["name"]); 
        echo $targetFile;
        // Di chuyển file ảnh vào thư mục đích
        if (move_uploaded_file($_FILES["productImage"]["tmp_name"], $targetFile)) { 
            // Thành công: file ảnh đã được di chuyển và sẵn sàng để lưu vào cơ sở dữ liệu
        } else {
            // Xử lý lỗi khi di chuyển file ảnh
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Kiểm tra và xử lý giá bán
    if (isset($_POST['productPrice'])) {
        $sanpham->setPrice($_POST['productPrice']);
    }

    // Kiểm tra và xử lý mô tả sản phẩm
    if (isset($_POST['productDescription'])) {
        $productDescription = $_POST['productDescription'];
        $mota = nl2br($productDescription);
        $sanpham->setCode($mota);
    }

    // Kiểm tra và xử lý loại sản phẩm
    if (isset($_POST['productCategory'])) {
        $sanpham->setIDcategory($_POST['category']);
    }

    // Kiểm tra và xử lý hãng sản phẩm
    if (isset($_POST['productType'])) {
        $sanpham->setloai($_POST['brands']);
    }

   
    header('Location: ../web/admin.php');
    exit();
}
?>
