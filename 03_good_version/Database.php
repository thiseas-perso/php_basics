<?php

namespace app;

use PDO;

class Database
{
   public $pdo;
   public function __construct()
   {
      $this->pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=products_crud', 'root', '');
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   }

   public function getProducts($searchQuery = '')
   {
      if ($searchQuery) {
         $statement = $this->pdo->prepare("SELECT * FROM products WHERE title LIKE :title ORDER BY create_date DESC");
         $statement->bindValue(":title", "%$searchQuery%");
      } else {
         $statement = $this->pdo->prepare("SELECT * FROM products ORDER BY create_date DESC");
      }
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_ASSOC);
   }
}
