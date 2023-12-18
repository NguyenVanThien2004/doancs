<?php 
require('../doan/model/database.php');
require('../doan/model/sanpham_db.php'); // Import file sanpham_db.php để sử dụng model sản phẩm
require('../doan/model/sanpham.php');


// Lấy danh sách sản phẩm từ cơ sở dữ liệu
$sanphamdb = new sanphamdb();
$products = $sanphamdb->getAllProduct();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trang Admin - Quản lý sản phẩm</title>
  <!-- CSS Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

  <div class="container mt-5">
    <h1 class="mb-4">Trang Quản lý Sản phẩm</h1>

    <!-- Bảng hiển thị danh sách sản phẩm -->
    <div class="card">
      <div class="card-header">
        Danh sách Sản phẩm
      </div>
      <div class="card-body">
        <!-- Bảng chứa thông tin sản phẩm -->
        <table class="table">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Tên Sản phẩm</th>
              <th scope="col">Giá</th>
              <th scope="col">Hành động</th>
            </tr>
          </thead>
          <?php 
          echo '<tbody>';
          foreach ($products as $product){
            echo '<tr>';
            echo '<th scope="row">'.$product->getIDsp().'</th>';
            echo '<td>'.$product->getNamesp().'</td>';
            echo '<td>'.$product->getPrice().'</td>';
            echo '<td>';
            echo '<button class="btn btn-sm btn-primary" onclick="editProduct(' . $product->getIDsp() . ')">Sửa</button>';
            echo '<button class="btn btn-sm btn-danger" onclick="deleteProduct(' . $product->getIDsp() . ')">Xoá</button>';
            echo '</td>';
            echo '</tr>';
          }
          echo '</tbody>';
          ?>
        </table>
      </div>
    </div>

    <!-- Nút thêm sản phẩm -->
    <div class="mt-4">
  <button class="btn btn-success" onclick="showAddProductForm()">Thêm Sản phẩm</button>
</div>

  </div>

  <!-- Modal Sửa thông tin sản phẩm -->
  <div id="editProductModal" class="modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Sửa thông tin sản phẩm</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal Body -->
        <div class="modal-body">
          <form id="editProductForm">
            <input type="text" id="productName" placeholder="Tên sản phẩm">
            <input type="text" id="productPrice" placeholder="Giá">
            <!-- Thêm các trường thông tin khác tương ứng với sản phẩm -->
            <button type="button" onclick="saveEditedProduct()">Lưu</button>
          </form>
        </div>
      </div>
    </div>
  </div>




<!-- Modal Thêm sản phẩm -->
<div id="addProductModal" class="modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Thêm Sản phẩm</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal Body -->
        <div class="modal-body">
        <form id="addProductForm">
       <input type="text" id="productCategory" placeholder="Loại mặt hàng">
      <input type="text" id="productName" placeholder="Tên sản phẩm">
     <input type="text" id="productDescription" placeholder="Mô tả">
     <input type="text" id="productPrice" placeholder="Giá">
     <input type="file" id="productImage" placeholder="Hình ảnh">
     <input type="text" id="productType" placeholder="Loại sản phẩm">
     <button type="button" onclick="saveNewProduct()">Lưu</button>
</form>

        </div>
      </div>
    </div>
  </div>
  <!-- JavaScript Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function deleteProduct(idsp) {
      if (confirm('Bạn có chắc chắn muốn xoá sản phẩm này không?')) {
        // Gửi yêu cầu xóa sản phẩm đến máy chủ bằng AJAX
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState === 4 && this.status === 200) {
            // Nếu xóa thành công, làm mới trang để cập nhật danh sách sản phẩm
            location.reload();
          }
        };
        xhttp.open("GET", "delete_product.php?idsp=" + idsp, true);
        xhttp.send();
      }
    };

    function editProduct(idsp) {
    currentIDsp = idsp; // Lưu lại idsp của sản phẩm cần sửa
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            var product = JSON.parse(this.responseText);

            document.getElementById("productName").value = product.namesp;
            document.getElementById("productPrice").value = product.price;

            var modal = document.getElementById("editProductModal");
            modal.style.display = "block";
        }
    };
    xhttp.open("GET", "get_product.php?idsp=" + idsp, true);
    xhttp.send();
}

var currentIDsp;
function saveEditedProduct() {
    var editedProductName = document.getElementById("productName").value;
    var editedProductPrice = document.getElementById("productPrice").value;
    
    // Sử dụng giá trị idsp đã lưu trữ
    var idsp = currentIDsp;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            var modal = document.getElementById("editProductModal");
            modal.style.display = "none";
            location.reload();
        }
    };
    xhttp.open("POST", "update_product.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("idsp=" + idsp + "&productName=" + editedProductName + "&productPrice=" + editedProductPrice);
}
function showAddProductForm() {
    var modal = document.getElementById("addProductModal");
    modal.style.display = "block";
  }

  function saveNewProduct() {
    var productCategory = document.getElementById("productCategory").value;
    var productName = document.getElementById("productName").value;
    var productDescription = document.getElementById("productDescription").value;
    var productPrice = document.getElementById("productPrice").value;
    var productImage = document.getElementById("productImage").files[0]; // Lấy file hình ảnh
    var productType = document.getElementById("productType").value;

    var formData = new FormData(); // Tạo đối tượng FormData để gửi dữ liệu form và file

    // Thêm thông tin sản phẩm vào FormData
    formData.append("productCategory", productCategory);
    formData.append("productName", productName);
    formData.append("productDescription", productDescription);
    formData.append("productPrice", productPrice);
    formData.append("productImage", productImage); // Thêm file hình ảnh vào FormData
    formData.append("productType", productType);

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4) {
            if (this.status === 200) {
                var modal = document.getElementById("addProductModal");
                modal.style.display = "none";
                location.reload();
            } else {
                // Hiển thị thông báo lỗi khi xảy ra lỗi
                console.error("Có lỗi khi thêm sản phẩm:", this.status, this.responseText);
            }
        }
    };
    xhttp.open("POST", "add_product.php", true);
    xhttp.send(formData); // Gửi FormData chứa thông tin sản phẩm và file hình ảnh
}

  </script>
</body>
</html>
