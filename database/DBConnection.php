<?php

require_once PATH_TO_PROJECT . '/bootstrap/base-config.php';

class DBConnection
{
    private static array $instances = [];

    private function __construct()
    {
    }

    protected function __clone()
    {
    }

    public function __wakeup()
    {
        throw new Exception("Cannot unserialize a singleton.");
    }

    private static function createPDOConnection(): ?PDO
    {
        try {
            $connection = new PDO(DATABASE . ":host=" . HOST . ";dbname=" . DBNANE, USERNAME, PASSWORD);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $connection;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();

            return null;
        }
    }

    public static function getInstance(): ?PDO
    {
        $className = self::class;
        if (!isset(self::$instances[$className])) {
            self::$instances[$className] = self::createPDOConnection();
        }

        return self::$instances[$className];
    }
}
