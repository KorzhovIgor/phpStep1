<?php
class DBConnection
{
    private static ?DBConnection $db = null;
    private static ?PDO $pdo = null;

    private function __construct() {
        try {
            $conn = new PDO("mysql:host=localhost;dbname=stratdb", "root", "ivalin60");
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this::$pdo = $conn;
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public static function getInstance(): ?PDO {
        if (self::$db === null) {
            self::$db = new self;
            return self::$pdo;
        }

        return self::$pdo;
    }
}
