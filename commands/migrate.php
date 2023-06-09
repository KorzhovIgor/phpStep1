<?php

require_once PATH_TO_PROJECT . '/app/models/Migration.php';

define('PATH_TO_MIGRATIONS', PATH_TO_PROJECT . '/database/migrations/');

$connection = DBConnection::getInstance();
$migrationModel = new Migration();

if (isset($argv[2])) {
    $migrationFile = array(PATH_TO_MIGRATIONS . $argv[2]);
    migrate($migrationModel, $connection, $migrationFile);
} else {
    $allFiles = glob(PATH_TO_MIGRATIONS . '*.sql');
    migrate($migrationModel, $connection, $allFiles);
}

function migrate(Migration $migrationModel, PDO $connection, array $allFiles)
{
    if (checkExistTable($connection, 'migrations')) {
        $migrations = $migrationModel->getAll();
        foreach ($allFiles as $file) {
            $isFileMigrated = 0;
            foreach ($migrations as $migration) {
                $fileName = substr($file, strlen(PATH_TO_MIGRATIONS));
                if ($migration['name'] === $fileName) {
                    $isFileMigrated++;
                }
            }
            if ($isFileMigrated === 0) {
                $preparedFile = implode('', (file($file)));
                $connection->exec($preparedFile);
                $fileName = substr($file, strlen(PATH_TO_MIGRATIONS));
                echo $fileName . " was migrated\n";
                $migrationModel->store($fileName);
            }
        }
    } else {
        createTableForMigrations($connection);
        foreach ($allFiles as $file) {
            $preparedFile = implode('', (file($file)));
            $connection->exec($preparedFile);
            $fileName = substr($file, strlen(PATH_TO_MIGRATIONS));
            $migrationModel->store($fileName);
            echo $fileName . " was migrated\n";
        }
    }
}

function createTableForMigrations(PDO $connection)
{
    $sql = <<<SQL
            CREATE TABLE migrations (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                created_at date NOT NULL
            )
    SQL;
    $preparedRequest = $connection->prepare($sql);
    $preparedRequest->execute();
}

function checkExistTable(PDO $connection, string $tableName) : bool
{
    $sql = <<<SQL
        SHOW TABLES LIKE '{$tableName}'
    SQL;
    $q = $connection->query($sql);

    return $q->fetchColumn();
}
