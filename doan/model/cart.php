<?php 
class Cart {
    private $cart_id;
    private $user_id;
    private $product_id;
    private $quantity;

    public function __construct($cart_id, $user_id, $product_id, $quantity) {
        $this->cart_id = $cart_id;
        $this->user_id = $user_id;
        $this->product_id = $product_id;
        $this->quantity = $quantity;
    }

    public function getCartID() {
        return $this->cart_id;
    }

    public function getUserID() {
        return $this->user_id;
    }

    public function getProductID() {
        return $this->product_id;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setCartID($cart_id) {
        $this->cart_id = $cart_id;
    }

    public function setUserID($user_id) {
        $this->user_id = $user_id;
    }

    public function setProductID($product_id) {
        $this->product_id = $product_id;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }
}
?>