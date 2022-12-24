<?php

namespace app\core;

class Database
{

    public \PDO $pdo;

    public function __construct(array $config)
    {
        $dsn = $config['dsn'] ?? '';
        $user = $config['user']?? '';
        $password = $config['password']?? '';
        $this->pdo = new \PDO($dsn, $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function applyMigration() {

        $this->createMigrationTable();
        $appliedMigrations =$this->getAppliedMigration();

        $files = scandir(Application::$ROOT_DIR."/migrations");
        $toApplyMigrations= array_diff($files, $appliedMigrations);

        foreach ($toApplyMigrations as $migration) {
            if($migration ==='.' || $migration='..') {
                continue;
            }
            require_once Application::$ROOT_DIR.'/migrations/'.$migration;

            $className = pathinfo($migration, PATHINFO_FILENAME);
        }




}

public function createMigrationTable() {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations(
    id INT AUTO_INCREMENT PRIMARY KEY,
    migration VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )ENGINE=INNODB;");
}

public function getAppliedMigration() {
        $statement = $this->pdo->prepare("SELECT migration FROM migrations");
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_COLUMN);
}


}