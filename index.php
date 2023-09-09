<?php

class Database {
  private $dbMaster;
  private $dbSlave;
  private $conn_error;
  

  public function __construct(string $driver, array $dbConfig) {
    $this->connect($driver, $dbConfig);
  }

  public function isConnectionError(): bool {
    return $this->conn_error != "";
  }

  public function getConnectionError(): string {
    return $this->conn_error != "";
  }

  


  private function connect(string $driver, array $dbConfig) {
    // connect to master and slave database
    $dsnMasterStr = $driver.":host=".$dbConfig['DB_MASTER_HOST'].";dbname=".$dbConfig['DB_NAME'].";port=".$dbConfig['DB_MASTER_PORT'];
    $dsnSlaveStr = $driver.":host=".$dbConfig['DB_SLAVE_HOST'].";dbname=".$dbConfig['DB_NAME'].";port=".$dbConfig['DB_SLAVE_PORT'];
    try {
      $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
      ];

      $this->dbMaster = new PDO($dsnMasterStr, $dbConfig['DB_MASTER_USER'], $dbConfig['DB_MASTER_PASS'], $options);
      $this->dbSlave =  new PDO($dsnSlaveStr, $dbConfig['DB_MASTER_USER'], $dbConfig['DB_SLAVE_PASS'], $options);
    } catch (PDOException $e) {
      $this->conn_error = $e->getMessage();
    }
  }

  // ... db func query

}


$dbConfig = [
  'DB_NAME' => 'blogs',
  'DB_MASTER_USER' => 'user',
  'DB_MASTER_PASS' => 'password',
  'DB_MASTER_HOST' => '127.0.0.1',
  'DB_SLAVE_HOST' => '127.0.0.1',
  'DB_MASTER_PORT' => '3306',
  'DB_SLAVE_PORT' => '3307',
  'DB_SLAVE_USER' => 'user',
  'DB_SLAVE_PASS' => 'password'
];

$conn = new Database("mysql", $dbConfig);
if ($conn->isConnectionError()) {
  die($conn->getConnectionError());
}

// query insert

// query select

// connection to mysql with PHP
echo "Hello world";