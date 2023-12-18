<?php 

session_start();

require('../doan/model/database.php');
require('../doan//model/category.php');
require('../doan/model/sanpham.php');
require('../doan/model/sanpham_db.php');
require('../doan/model/category_db.php');
require('../doan/model/sanphamcon_db.php');
require('../doan/model/sanphamcon.php');
require('../doan/model/user.php');
$sanphamdb= new sanphamdb();
$listsanpham= $sanphamdb->getProducts();

$loaidb= new CategoryDB();
$listloai= $loaidb->getCategories();





?> 
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="index1.php">24/7</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Rau Củ
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Cart</a>
        </li>
        <li class="nav-item">
          <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
        </li>
      </ul>
      <form class="d-flex">
        <button class="btn btn-outline-success" type="button" onclick="redirectToPage('login.php')">Log Out</button>
      </form>
    </div>
  </div>
</nav>
<!--product------------------->
<?php
if (isset($_GET['idspp'])) {
  $idsp = $_GET['idspp'];
  $pro = new sanphamdb();
  $product = $pro->getProductbyid($idsp);

  if ($product) {
    echo '<div class="row">';
    echo '  <div class="col-md-6">';
    echo '    <img src="'.$product->getImageAltText().'"Ảnh sản phẩm" class="img-fluid">';
    echo '  </div>';
    echo '  <div class="col-md-6">';
    echo '    <h2>Tên sản phẩm: ' . $product->getNamesp() . '</h2>';
    echo '    <p class="lead">Giá: ' . $product->getPrice() . '</p>';
    echo '    <p>Mô tả sản phẩm:</p>';
    echo '    <p>' . $product->getCode() . '</p>';
    echo '<p> <a href="giohang.php?idspp='.$product->getIDsp().'" class="btn btn-primary add-to-cart" name="butonn">Thêm vào giỏ hàng</a> <p> ';
    echo '  </div>';
    echo '</div>';
  } else {
    echo 'Không tìm thấy sản phẩm.';
  }
}

?>


<script>
  function redirectToPage(pageUrl) {
    // Chuyển hướng tới trang khác
    window.location.href = pageUrl;
  }
  $(document).ready(function() {
    $('.add-to-cart').click(function(e) {
        e.preventDefault();

        var url = $(this).attr('href');

        $.ajax({
            type: 'GET',
            url: url,
            success: function(response) {
                alert('Thêm vào giỏ hàng thành công');
            },
            error: function() {
                alert('Có lỗi xảy ra. Vui lòng thử lại sau');
            }
        });
    });
});
</script>
<script src="js/bootstrap.js"></script>
</body>
</html>
