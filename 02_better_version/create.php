<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);


require_once 'functions.php';
require_once 'database.php';

$errors = [];
$title = '';
$description = '';
$price = '';
$product = [
   'image' => ''
];


// echo '<pre>';
// var_dump($_FILES);
// echo '</pre>';
// exit;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

   require_once 'validate_product.php';

   if (empty($errors)) {
      $statement = $pdo->prepare("INSERT INTO products (title, image, description, price, create_date) 
VALUES (:title, :image, :description, :price, :date)");
      $statement->bindValue(':title', $title);
      $statement->bindValue(':image', $imagePath);
      $statement->bindValue(':description', $description);
      $statement->bindValue(':price', $price);
      $statement->bindValue(':date', date('Y-m-d H:i:s'));
      $statement->execute();
      header('Location: index.php');
   }
};


?>

<?php require_once 'views/partials/header.php' ?>

<body>
   <h1>Your new product</h1>
   <p>
      <a href="index.php" class="btn btn-secondary">Back to products</a>
   </p>
   <?php include_once "views/products/form.php" ?>
</body>

</html>