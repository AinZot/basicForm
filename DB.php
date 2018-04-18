<?php

class DB {

    private static $instance = null;

    public static function get() {
        
        $dbName = 'form';
        $user = '******';
        $password = '*****';
        
        if (self::$instance == null) {
            try {
                self::$instance = new PDO("mysql:host=localhost;dbname=$dbName", $user, $password);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                throw $e;
            }
        }
        return self::$instance;
    }

}
