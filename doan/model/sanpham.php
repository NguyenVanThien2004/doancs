<?php
class Product{
    private $idsp, $idcategory, $tensp, $mota, $gia, $hinhanh, $loaisp;
    public function __construct() {
        $this->idsp = 0;
        $this->tensp = '';
        $this->mota = '';
        $this->gia = 0;
        $this->hinhanh = 0;
        $this->loaisp = null;
    }
 
    public function getloai() {
        return $this->loaisp;
    }

    public function setloai($value) {
        $this->loaisp = $value;
    }

    public function getIDsp() {
        return $this->idsp;
    }

    public function setIDcategory($value) {
        $this->idcategory = $value;
    }

    public function getIDcategory() {
        return $this->idcategory;
    }

    public function setIDsp($value) {
        $this->idsp = $value;
    }

    public function getCode() {
        return $this->mota;
    }

    public function setCode($value) {
        $this->mota = $value;
    }

    public function getNamesp() {
        return $this->tensp;
    }

    public function setNamesp($value) {
        $this->tensp = $value;
    }

    public function getPrice() {
        $formatted_price = number_format($this->gia, 2);
        return $formatted_price;
    }

    public function setPrice($value) {
        $this->gia = $value;
    }


    public function getImageFilename() {
        $image_filename = $this->hinhanh . '.png';
        return $image_filename;
    }

    public function getImagePath() {
        $image_path = 'uploads/' . $this->getImageFilename();
        return $image_path;
    }

    public function getImageAltText() {
        
        return $this->hinhanh;
    }
    public function setImageAltText($value) {
        $this->hinhanh = $value;
    }
}
?>