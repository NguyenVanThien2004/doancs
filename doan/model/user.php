<?php
class User {
    private $id, $username, $email, $password;
   
    public function __construct() {
        $this->id = 0;
        $this->username = '';
        $this->email = '';
        $this->password = '';
    }

    public function getID() {
        return $this->id;
    }

    public function setID($value) {
        $this->id = $value;
    }

    public function getName() {
        return $this->username;
    }

    public function setName($value) {
        $this->username = $value;
    }
    public function getEmail() {
        return $this->email;
    }

    public function setEmail($value) {
        $this->email = $value;
    }
    public function getPassword() {
        return $this->password;
    }

    public function setPassword($value) {
        $this->password = $value;
    }

}
?>