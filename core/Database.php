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



        $newMigrations = [];
        $files = scandir(Application::$ROOT_DIR."/migrations");
        $toApplyMigrations= array_diff($files, $appliedMigrations);

        $this->log($toApplyMigrations);

        foreach ($toApplyMigrations as $migration) {

            if($migration ==='.') {
                continue;
            }

            if($migration ==='..') {
                continue;
            }






            $this->log($migration);


            require_once Application::$ROOT_DIR.'/migrations/'.$migration;

            $className = pathinfo($migration, PATHINFO_FILENAME);

            $this->log($className);

            $instance = new $className();

            $instance->up();

            $newMigrations[] = $migration;

            $this->log($migration);


        }

        if(!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);

        } else {
            $this->log('All migrations applied');
        }




}

 public function saveMigrations(array $migrations) {
       $this->log($migrations);
        $str = implode(",",array_map(fn($m) => "('$m')", $migrations));
        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $str");
        $statement->execute();
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

public function log($message) {
        echo '[' .date('y-m-d H:i:s').'] - '  .  $message  .  PHP_EOL;
}


}