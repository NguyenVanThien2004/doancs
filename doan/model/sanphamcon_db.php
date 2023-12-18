<?php 
//  class sanphamcondb{
//     public function getProductcons() {
//         $db = Database::getDB();
//         $query = 'SELECT * FROM productcon
//                 ';
//         $result = $db->query($query);
//         $productcons = array();
//         foreach ($result as $row) {           
//             // create the Productcons object
//             $productcon = new Productcon();
//             $productcon->setidspcon($row['idspcon']);
//             $productcon->setloai($row['loaisp_con']);
//             $productcon->setIDcategory($row['idsp_parent']);
//             $productcon->setNamesp($row['tensp_con']);
//             $productcon->setCode($row['mota_con']);
//             $productcon->setPrice($row['gia_con']);
//             $productcon->setImageAltText($row['hinhanh_con']);
//             $productcons[] = $productcon;
//         }
//         return $productcons;
//     }
//     public function getProductconbyidloai($idloai) {
//         $db = Database::getDB();
//         $query = 'SELECT * FROM productcon WHERE $idloai = idsp_parent;
//                 ';
//        $result = $db->query($query);
//        $productcons = array();
//        foreach ($result as $row) {           
//            // create the Productcons object
//            $productcon = new Productcon();
//            $productcon->setidspcon($row['idspcon']);
//            $productcon->setloai($row['loaisp_con']);
//            $productcon->setIDcategory($row['idsp_parent']);
//            $productcon->setNamesp($row['tensp_con']);
//            $productcon->setCode($row['mota_con']);
//            $productcon->setPrice($row['gia_con']);
//            $productcon->setImageAltText($row['hinhanh_con']);
//            $productcons[] = $productcon;
//        }
//        return $productcons;
//      }
//  }
?>