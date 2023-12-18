<?php
if (isset($_GET['idsp'])) {
    $idsp = $_GET['idsp'];
    require('../doan/model/database.php');
    require('../doan/model/sanpham_db.php');
    require('../doan/model/sanpham.php');

    $sanphamdb = new sanphamdb();
    $sanphamdb->deleteProduct($idsp);
}
?>
