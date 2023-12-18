<?php 
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
        <?php 
        foreach($listloai as $loai){
         echo '<li class="nav-item dropdown">';
         echo '<a class="nav-link dropdown" href="index.php?idloai='.$loai->getID().'" role="button"  >
            '.$loai->getName().'
          </a>'; 
         echo '<ul class="dropdown-menu">';
         echo '</ul>';
         echo '</li>';
        }
        ?>
        <li class="nav-item">
          <a class="nav-link" href="#">Cart</a>
        </li>
        <li class="nav-item">

          <form class="d-flex" method="GET">
            <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
        </li>
      </ul>
      <form class="d-flex">
        <button class="btn btn-outline-success" type="button" onclick="redirectToPage('login.php')">Log In</button>
      </form>
    </div>
  </div>
</nav>
<!-- banner------------------->
<div id="carouselExampleCaptions" class="carousel slide">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="image/6.png" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>First slide label</h5>
        <p></p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="image/2.png" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>Second slide label</h5>
        <p></p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="image/3.png" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>Third slide label</h5>
        <p></p>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
<!-- item------------->
<?php
// Kiểm tra nếu có yêu cầu tìm kiếm
if (isset($_GET['search'])) {
    $searchKeyword = $_GET['search'];
    $sanphamdb = new sanphamdb();
    $searchResults = $sanphamdb->searchProduct($searchKeyword);
    if (!empty($searchResults)) {
        echo '<div class="row">';
        foreach ($searchResults as $product) {
            echo '<div class="col-md-3 product-col">';
            echo '<div class="card" style="width: 18rem;">';
            echo '<img src="'.$product->getImageAltText().'" class="card-img-top" alt="...">';
            echo '<div class="card-body">';
            echo '<h5><a href="danhsachsanpham.php?idspp=' . $product->getIDsp() . '">' . $sanpham->getNamesp() . '</a></h5>';
            echo '<p class="card-text">'.$product->getCode().'</p>';
            echo '<p class="card-text">'.$product->getPrice().'</p>';
            echo '<a href="danhsachsanpham.php?idspp='.$product->getIDsp().'" class="btn btn-primary" name="buton">Chi tiết sản phẩm</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo '<p>No results found.</p>';
    }
}
else if(isset( $_GET['idloai'] )){
   $ideloai = $_GET['idloai'];
   $spdtb = new sanphamdb();
   $listsp = $spdtb->getProductbyidloai($ideloai);
   echo '<div class="row">';
    foreach ($listsp as $sanpham) {
        echo '<div class="col-md-3">';
        echo '<div class="card" style="width: 18rem;">';
        echo '<img src="'.$sanpham->getImageAltText().'" class="card-img-top" alt="...">';
        echo '<div class="card-body">';
        echo '<h5><a href="danhsachsanpham.php?idspp=' . $sanpham->getIDsp() . '">' . $sanpham->getNamesp() . '</a></h5>';
        echo '<p class="card-text">'.$sanpham->getCode().'</p>';
        echo '<p class="card-text">'.$sanpham->getPrice().'</p>';
        echo '<a href="danhsachsanpham.php?idspp='.$sanpham->getIDsp().'" class="btn btn-primary" name="buton">Chi tiết sản phẩm</a>';
           
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
}
else {
    // Hiển thị sản phẩm mặc định nếu không có yêu cầu tìm kiếm
    echo '<div class="row">';
    foreach ($listsanpham as $sanpham) {
        echo '<div class="col-md-3">';
        echo '<div class="card" style="width: 18rem;">';
        echo '<img src="'.$sanpham->getImageAltText().'" class="card-img-top" alt="...">';
        echo '<div class="card-body">';
        echo '<h5><a href="danhsachsanpham.php?idspp=' . $sanpham->getIDsp() . '">' . $sanpham->getNamesp() . '</a></h5>';
        echo '<p class="card-text">'.$sanpham->getCode().'</p>';
        echo '<p class="card-text">'.$sanpham->getPrice().'</p>';
        echo '<a href="danhsachsanpham.php?idspp='.$sanpham->getIDsp().'" class="btn btn-primary" name="buton">Chi tiết sản phẩm</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
}
?>



<script>
  function redirectToPage(pageUrl) {
    // Chuyển hướng tới trang khác
    window.location.href = pageUrl;
  }

</script>
<script src="js/bootstrap.js"></script>
</body>
</html>