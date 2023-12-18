<?php 
class Productcon extends Product {
    private $idspcon, $idspcha;

    public function __construct() {
        parent::__construct();
        $this->idspcon = 0;
    }

    public function getidspcon() {
        return $this->idspcon;
    }

    public function setidspcon($value) {
        $this->idspcon = $value;
    }
}
?>