<?php

class Dbh
{
  private $serverName;
  private $userName;
  private $password;
  private $dbName;
  private $charset;

  protected function connect()
  {
    $this->serverName = "172.20.0.1";
    $this->userName = "root";
    $this->password = "pwd123";
    $this->dbName = "my_db";
    $this->charset = "utf8mb4";
    try {
      $dsn = "mysql:host=" . $this->serverName . ";dbname=" . $this->dbName . ";charset=" . $this->charset;
      $pdo = new PDO($dsn, $this->userName, $this->password);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $pdo;
    } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
  }
}
