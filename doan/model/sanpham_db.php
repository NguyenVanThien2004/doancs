<?php 
 class sanphamdb{
    public function getProducts() {
        $db = Database::getDB();
        $query = 'SELECT * FROM product
                ';
        $result = $db->query($query);
        $products = array();
        foreach ($result as $row) {
           
            // create the Product object
            $product = new Product();
            $product->setIdsp($row['idsp']);
            $product->setloai($row['loaisp']);
            $product->setNamesp($row['tensp']);
            $product->setCode($row['mota']);
            $product->setPrice($row['gia']);
            $product->setImageAltText($row['hinhanh']);
            $products[] = $product;
        }
        return $products;
    }
 
 public function getProductbyname($tensanpham) {
    $db = Database::getDB();
    $query = 'SELECT * FROM product WHERE $tensanpham = tensp;
            ';
    $result = $db->query($query);
    $products = array();
    foreach ($result as $row) {
       
        // create the Product object
        $product = new Product();
        $product->setIdsp($row['idsp']);
        $product->setloai($row['loaisp']);
        $product->setNamesp($row['tensp']);
        $product->setCode($row['mota']);
        $product->setPrice($row['gia']);
        $product->setImageAltText($row['hinhanh']);
        $products[] = $product;
    }
    return $products;
 }


 public function getProductbyidloai($idloai) {
    $db = Database::getDB();
    $query = "SELECT * FROM product WHERE idcategory = $idloai;";
    $result = $db->query($query);
    $products = array();
    foreach ($result as $row) {
       
        // create the Product object
        $product = new Product();
        $product->setIdsp($row['idsp']);
        $product->setloai($row['loaisp']);
        $product->setNamesp($row['tensp']);
        $product->setCode($row['mota']);
        $product->setPrice($row['gia']);
        $product->setImageAltText($row['hinhanh']);
        $products[] = $product;
    }
    return $products;
 }

 public function getProductbyID1($idloai) {
    $db = Database::getDB();
    $query = "SELECT * FROM product WHERE idsp = $idloai;";
    $result = $db->query($query);
    $products = array();
    foreach ($result as $row) {
       
        // create the Product object
        $product = new Product();
        $product->setIdsp($row['idsp']);
        $product->setloai($row['loaisp']);
        $product->setNamesp($row['tensp']);
        $product->setCode($row['mota']);
        $product->setPrice($row['gia']);
        $product->setImageAltText($row['hinhanh']);
        $products[] = $product;
    }
    return $products;
 }


 public function getProductbyid($idsp) {
    $db = Database::getDB();
    $query = "SELECT * FROM product WHERE idsp = $idsp;";
    $result = $db->query($query);
    
    // Lấy một dòng dữ liệu duy nhất từ kết quả truy vấn
    $row = $result->fetch(PDO::FETCH_ASSOC);
    
    if (!$row) {
        return null; // Trả về null nếu không tìm thấy sản phẩm
    }
    
    // Tạo đối tượng Product và thiết lập các thuộc tính
    $product = new Product();
    $product->setIdsp($row['idsp']);
    $product->setloai($row['loaisp']);
    $product->setNamesp($row['tensp']);
    $product->setCode($row['mota']);
    $product->setPrice($row['gia']);
    $product->setImageAltText($row['hinhanh']);
    
    return $product;
}

 public function searchProduct($keyword) {
    $db = Database::getDB();
    $query = "SELECT * FROM product WHERE tensp LIKE '%$keyword%'";
    $result = $db->query($query);
    $products = array();
    foreach ($result as $row) {
        // create the Product object
        $product = new Product();
        $product->setIdsp($row['idsp']);
        $product->setloai($row['loaisp']);
        $product->setNamesp($row['tensp']);
        $product->setCode($row['mota']);
        $product->setPrice($row['gia']);
        $product->setImageAltText($row['hinhanh']);
        $products[] = $product;
    }
    return $products;
}
public function getAllProduct() {
    $db = Database::getDB();
    $query = 'SELECT * FROM product';
    $result = $db->query($query);
    $products = array();
    
    foreach ($result as $row) {
        // Tạo đối tượng Product và thiết lập các thuộc tính
        $product = new Product();
        $product->setIdsp($row['idsp']);
        $product->setloai($row['loaisp']);
        $product->setNamesp($row['tensp']);
        $product->setCode($row['mota']);
        $product->setPrice($row['gia']);
        $product->setImageAltText($row['hinhanh']);
        $products[] = $product;
    }
    
    return $products;
}
public function deleteProduct($idsp) {
    $db = Database::getDB();
    $query = "DELETE FROM product WHERE idsp = :idsp";
    $statement = $db->prepare($query);
    $statement->bindValue(':idsp', $idsp);
    $statement->execute();
}

// Các hàm khác trong class sanphamdb
public function updateProduct($product) {
    $db = Database::getDB();

    // Lấy thông tin cần cập nhật từ đối tượng Product
    $idsp = $product->getIDsp();
    $productName = $product->getNamesp();
    $productPrice = $product->getPrice();

    // Câu truy vấn cập nhật thông tin sản phẩm trong cơ sở dữ liệu
    $query = "UPDATE product 
              SET tensp = :productName, gia = :productPrice
              WHERE idsp = :idsp";

    // Sử dụng Prepared Statements để thực hiện câu truy vấn cập nhật
    $statement = $db->prepare($query);
    $statement->bindValue(':productName', $productName);
    $statement->bindValue(':productPrice', $productPrice);
    $statement->bindValue(':idsp', $idsp);
    
    // Thực thi truy vấn
    $result = $statement->execute();

    // Trả về kết quả cập nhật, true nếu thành công, false nếu không thành công
    return $result;
}

public function addProduct($productCategory, $productName, $productDescription, $productPrice, $productImagePath, $productType) {
    $db = Database::getDB(); 
    try {
        $sql = "INSERT INTO product ( idcategory, tensp, mota, gia, hinhanh, loaisp) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $productCategory);
        $stmt->bindParam(2, $productName);
        $stmt->bindParam(3, $productDescription);
        $stmt->bindParam(4, $productPrice);
        $stmt->bindParam(5, $productImagePath); // Chú ý: Sử dụng đường dẫn hình ảnh, không phải file hình ảnh trực tiếp
        $stmt->bindParam(6, $productType);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        return false;
    }
}



}
?>