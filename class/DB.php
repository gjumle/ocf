<?php

class DB {
    static $conn = null;

    static function getConnection() {
        if (self::$conn == null) {
            $db = new mysqli('localhost', 'ocf', 'ocf', 'ocf');
            self::$conn = $db;
        } else {
            $db = self::$conn;
        }
        return $db;
    }
}
