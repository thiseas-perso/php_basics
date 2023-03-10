<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$errors = [];
$title = '';
$description = '';
$price = '';


// echo '<pre>';
// var_dump($_FILES);
// echo '</pre>';
// exit;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $title = $_POST["title"];
   $description = $_POST["description"];
   $price = $_POST["price"];
   $date = date('Y-m-d H:i:s');



   if (!$title) {
      $errors[] = "product title is required";
   }
   if (!$price) {
      $errors[] = "product price is required";
   }

   if (!is_dir("images")) {
      mkdir('images');
   }

   if (empty($errors)) {
      $image = $_FILES['image'] ?? null;
      $imagePath = '';
      // $foo = $bar ?? 'something';
      // $foo = isset($bar) ? $bar : 'something';

      if ($image && $image["tmp_name"]) {
         $imagePath = 'images/' . randomString(8) . '/' . $image['name'];
         mkdir(dirname($imagePath));
         move_uploaded_file($image['tmp_name'], $imagePath);
      }

      $statement = $pdo->prepare("INSERT INTO products (title, image, description, price, create_date) 
VALUES (:title, :image, :description, :price, :date)");
      $statement->bindValue(':title', $title);
      $statement->bindValue(':image', $imagePath);
      $statement->bindValue(':description', $description);
      $statement->bindValue(':price', $price);
      $statement->bindValue(':date', $date);
      $statement->execute();
      header('Location: index.php');
   }
};

function randomString($n)
{
   $characters = '0123456789abcdefghijklmnopgrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
   $str = '';
   for ($i = 0; $i < $n; $i++) {
      $index = rand(0, strlen($characters) - 1);
      $str .= $characters[$index];
   }
   return $str;
}
?>

<!doctype html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Create a product</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
   <link rel="stylesheet" href="app.css">
</head>

<body>
   <h1>Your new product</h1>
   <?php if (!empty($errors)) : ?>
      <div class="alert alert-danger">
         <?php foreach ($errors as $error) : ?>
            <div><?php echo $error ?></div>
         <?php endforeach ?>
      </div>
   <?php endif ?>
   <form action="" method="post" enctype="multipart/form-data">
      <div class="mb-3">
         <label for="image" class="form-label">Image</label>
         <input type="file" class="form-control" id="image" name="image">
      </div>
      <div class="mb-3">
         <label for="title" class="form-label">Title</label>
         <input type="text" class="form-control" id="title" name="title" value="<?php echo $title ?>">
      </div>
      <div class="mb-3">
         <label for="description" class="form-label">Description</label>
         <textarea class="form-control" id="description" name="description"><?php echo $description ?></textarea>
      </div>
      <div class="mb-3">
         <label for="price" class="form-label">Price</label>
         <input step="0.01" type="number" class="form-control" id="price" name="price" value="<?php echo $price ?>">
      </div>
      <button type="submit" class="btn btn-primary">Create</button>
   </form>
</body>

</html>