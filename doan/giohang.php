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


$db = Database::getDB();

?> 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Giỏ hàng</title>
  <!-- CSS Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
</head>
<style>
  .increment-quantity  {
  width: 30px;
  height: 30px;
  border: none;
  background-color: #f8f9fa;
  color: #212529;
  font-size: 18px;
  cursor: pointer;
  margin-right: 5px;
}

.increment-quantity :hover {
  background-color: #e9ecef;
}

.increment-quantity :focus {
  outline: none;
}
.decrement-quantity  {
  width: 30px;
  height: 30px;
  border: none;
  background-color: #f8f9fa;
  color: #212529;
  font-size: 18px;
  cursor: pointer;
  margin-right: 5px;
}

.decrement-quantity :hover {
  background-color: #e9ecef;
}

.decrement-quantity :focus {
  outline: none;
}
</style>
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
foreach($listloai as $loai) {
    echo '<li class="nav-item dropdown">';
    echo '<a class="nav-link dropdown" href="index.php?idloai='.$loai->getID().'" role="button" >'.$loai->getName().'</a>'; 
    echo '<ul class="dropdown-menu">';
    echo '</ul>';
    echo '</li>';
}
?>
        <li class="nav-item">
          <a class="nav-link" href="#">Cart</a>
        </li>
      
      </ul>
      <?php 
      if (isset($_POST['logout'])) {
        
// Xóa tất cả biến trong session
$_SESSION = array();

// Nếu cần xóa cookie session, hãy xóa cookie cũng
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Huỷ session
session_destroy();

// Sau đó, chuyển hướng đến trang đăng nhập hoặc trang khác
header('Location: login.php');
exit();

    }
      ?>
      <form class="d-flex" method="POST">
        <button class="btn btn-outline-success logout-button" type="submit" onclick="redirectToPage('index.php')" name="logout">Log Out</button>
      </form>
    </div>
  </div>
</nav>
  <div class="container">
    <h1>Giỏ hàng</h1>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Sản phẩm</th>
          <th scope="col">Giá</th>
          <th scope="col">Số lượng</th>
          <th scope="col">Thành tiền</th>
        </tr>
      </thead>
      <tbody>
<?php
if (isset($_GET['idspp'])) {
  $idsppp = $_GET['idspp'];
  $pro1 = new sanphamdb();
  $product = $pro1->getProductbyid($idsppp);
  if ($product) {
      $cartItem = [
          'id' => $product->getIDsp(),
          'name' => $product->getNamesp(),
          'price' => $product->getPrice(),
          'quantity' => 1

      ];

      // Kiểm tra xem giỏ hàng đã tồn tại trong session chưa
      if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
          $_SESSION['cart'] = [];
      }

      $found = false;

      // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
      foreach ($_SESSION['cart'] as &$item) {
        if(isset($item)){
          if ($item['id'] == $cartItem['id']) {
            $item['quantity']++;
            $found = true;
            break;
        }
        }
         
      }

      // Nếu sản phẩm chưa có trong giỏ hàng, thêm vào giỏ hàng
      if (!$found) {
          $_SESSION['cart'][] = $cartItem;
      }
       // Xoá các sản phẩm trùng lặp trong giỏ hàng
       $uniqueCartItems = [];
       foreach ($_SESSION['cart'] as $cartItem) {
        if(isset($cartItem)){
          $id = $cartItem['id'];
          if (!isset($uniqueCartItems[$id])) {
              $uniqueCartItems[$id] = $cartItem;
          }
        }
       }
       $_SESSION['cart'] = array_values($uniqueCartItems);
   }
 
  }
  

  echo '<tbody>';

  if (isset($_SESSION['cart']) && is_array($_SESSION['cart']) && !empty($_SESSION['cart'])) {
      $totalAmount = 0;
      foreach ($_SESSION['cart'] as $key => $cartItem) {
          if (isset($cartItem['name'], $cartItem['price'], $cartItem['quantity'])) {
              $price = str_replace(',', '', $cartItem['price']);
              $price = floatval($price);
  
              echo '<tr>';
              echo '<td class="product-name">' . $cartItem['name'] . '</td>';
              echo '<td class="product-price">' . $price . '</td>';
              echo '<td class="product-quantity"> <button class="decrement-quantity">-</button>' . $cartItem['quantity'] . '<button class="increment-quantity">+</button></td>';
              echo '<td class="product-subtotal">' . ($price * $cartItem['quantity']) . '</td>';
              echo '<td><button class="remove-item" data-key="' . $key  . '">X</button></td>';
              echo '</tr>';
  
              $totalAmount += ($price * $cartItem['quantity']);
              $productList[] = [
                'name' => $cartItem['name'],
                'price' => $price,
                'quantity' => $cartItem['quantity'],
                'subtotal' => ($price * $cartItem['quantity'])
            ];
          }
      }
  
      echo '<tfoot>';
      echo '<tr>';
      echo '<th colspan="3" class="text-end">Tổng cộng:</th>';
      echo '<th id="total-amount">' . $totalAmount . '</th>';
      echo '</tr>';
      echo '</tfoot>';
  }
  
  echo '</tbody>';

  // Assuming database connection and session handling are properly set up

if (isset($_POST['checkout'])) {
  // Check if the cart exists and has items
  if (isset($_SESSION['cart']) && is_array($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
      $user_id = $_SESSION['user_id'];

      try {
          $db = Database::getDB();
          // Get cart ID from the database
          $stmt = $db->prepare('SELECT cart_id FROM cart WHERE user_id = ?');
          $stmt->execute([$user_id]);

          if ($stmt->rowCount() > 0) {
              $row = $stmt->fetch(PDO::FETCH_ASSOC);
              $cart_id = $row['cart_id'];

              foreach ($_SESSION['cart'] as $cartItem) {
                  $id = $cartItem['id'];
                  $name = $cartItem['name'];
                  $price = $cartItem['price'];
                  $quantity = $cartItem['quantity'];

                  // Insert cart items into the database
                  $insertStmt = $db->prepare('INSERT INTO product_cart (idcart, idsp1, quantity) VALUES (?, ?, ?)');
                  $insertStmt->execute([$cart_id, $id, $quantity]);
              }

              echo 'Dữ liệu đã được lưu vào cơ sở dữ liệu thành công!';
          } else {
              echo 'Lỗi: Không tìm thấy cart_id!';
          }
      } catch (PDOException $e) {
          // Display any database errors
          echo 'Lỗi kết nối cơ sở dữ liệu: ' . $e->getMessage();
      }
  } else {
      echo 'Giỏ hàng của bạn đang trống!';
  }
}


?>
    </table>
    <button class="btn btn-primary" name="checkout">Thanh toán</button>
  </div>
  
  <!-- JavaScript Bootstrap -->
  <script> 
   document.addEventListener('click', function(event) {
  if (event.target && event.target.classList.contains('decrement-quantity')) {
    event.preventDefault();
    var quantityElement = event.target.nextElementSibling;
    var quantity = parseInt(quantityElement.textContent);

    if (quantity > 1) {
      quantity--;
      quantityElement.textContent = quantity;
      updateSubtotal(event.target.parentNode.parentNode);
      updateTotalAmount();
    }
  } else if (event.target && event.target.classList.contains('increment-quantity')) {
    event.preventDefault();
    var quantityElement = event.target.previousElementSibling;
    var quantity = parseInt(quantityElement.textContent);

    if (!isNaN(quantity)) { // Kiểm tra nếu quantity là một số hợp lệ
      quantity++;
      quantityElement.textContent = quantity;
      updateSubtotal(event.target.parentNode.parentNode);
      updateTotalAmount();
    }
  }
});

function updateSubtotal(row) {
  var priceElement = row.querySelector('.product-price');
  var quantityElement = row.querySelector('.product-quantity');
  var subtotalElement = row.querySelector('.product-subtotal');
  var price = parseFloat(priceElement.textContent);
  var quantity = parseInt(quantityElement.textContent);

  if (!isNaN(price) && !isNaN(quantity)) { // Kiểm tra nếu price và quantity là các số hợp lệ
    var subtotal = price * quantity;
    subtotalElement.textContent = subtotal;
  }
}

function updateTotalAmount() {
  var totalAmount = 0;
  var subtotalElements = document.getElementsByClassName('product-subtotal');

  for (var i = 0; i < subtotalElements.length; i++) {
    var subtotal = parseFloat(subtotalElements[i].textContent);

    if (!isNaN(subtotal)) { // Kiểm tra nếu subtotal là một số hợp lệ
      totalAmount += subtotal;
    }
  }

  var totalAmountElement = document.getElementById('total-amount');

  if (totalAmountElement) {
    totalAmountElement.textContent = totalAmount;
    updateTotalAmountOnServer(totalAmount); // Thêm hàm gọi AJAX để cập nhật totalAmount trên server
  }
}

function updateTotalAmountOnServer(totalAmount) {
  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'cap_nhat_total_amount.php', true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhr.send('totalAmount=' + totalAmount);
}

document.addEventListener('click', function(event) {
  if (event.target && event.target.classList.contains('remove-item')) {
    event.preventDefault();
    var key = event.target.getAttribute('data-key');

    if (key !== null) {
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'xoa_san_pham.php', true);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
          var response = xhr.responseText;

          if (response !== 'error') {
            var row = event.target.parentNode.parentNode;
            row.parentNode.removeChild(row);
            updateTotalAmount();
            var totalAmount = parseFloat(response);

            if (!isNaN(totalAmount)) { // Kiểm tra nếu totalAmount là một số hợp lệ
              document.getElementById('total-amount').textContent = totalAmount;
            }
          } else {
            console.log('Lỗi khi xóa sản phẩm khỏi giỏ hàng');
          }
        }
      };
      xhr.send('key=' + key);
    }
  }
});
document.addEventListener('click', function(event) {
    if (event.target && event.target.classList.contains('logout-button')) {
        event.preventDefault();

        // Gửi yêu cầu AJAX để xóa sản phẩm khỏi giỏ hàng
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete_cart_items.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    var response = xhr.responseText;

                    if (response === 'success') {
                        // Nếu xóa thành công, chuyển hướng hoặc thực hiện các hành động khác tùy ý
                        window.location.href = 'index.php'; // Chuyển hướng đến trang index.php hoặc trang khác
                    } else {
                        console.error('Lỗi khi xóa sản phẩm khỏi giỏ hàng');
                    }
                } else {
                    console.error('Đã xảy ra lỗi khi gửi yêu cầu');
                }
            }
        };

        // Gửi yêu cầu AJAX
        xhr.send();
    }
});

function redirectToPage(pageUrl) {
    // Chuyển hướng tới trang khác
    window.location.href = pageUrl;
  }
</script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>