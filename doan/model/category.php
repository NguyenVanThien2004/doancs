<?php
class Category {
    private $idloai;
    private $tenloai;

    public function __construct() {
        $this->idloai = 0;
        $this->tenloai = '';
    }

    public function getID() {
        return $this->idloai;
    }

    public function setID($value) {
        $this->idloai = $value;
    }

    public function getName() {
        return $this->tenloai;
    }

    public function setName($value) {
        $this->tenloai = $value;
    }
}
?>