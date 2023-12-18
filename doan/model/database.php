<?php
class database {
    private static $dsn = 'mysql:host=localhost;dbname=user_login_1';
    private static $username = 'root';
    private static $password = '';
    private static $db;

    private function __construct() {}

    public static function getDB () {
        if (!isset(self::$db)) {
         
                self::$db = new PDO(self::$dsn,
                                     self::$username,
                                     self::$password);
             
        }
        return self::$db;
    }
}
?>