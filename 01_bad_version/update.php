<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$id = $_GET['id'] ?? null;

if (!$id) {
   header("Location: index.php");
   exit;
}

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statement = $pdo->prepare('SELECT * FROM products WHERE id = :id');
$statement->bindValue(":id", $id);
$statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);

$errors = [];
$title = $product['title'];
$description = $product['description'];
$price = $product['price'];



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $title = $_POST["title"];
   $description = $_POST["description"];
   $price = $_POST["price"];


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
      $imagePath = $product['image'];


      if ($image && $image["tmp_name"]) {
         if ($product['image']) {
            unlink($product["image"]);
         }
         $imagePath = 'images/' . randomString(8) . '/' . $image['name'];
         mkdir(dirname($imagePath));
         move_uploaded_file($image['tmp_name'], $imagePath);
      }

      $statement = $pdo->prepare("UPDATE products SET title = :title, 
      image = :image, description = :description, 
      price = :price WHERE id = :id");
      $statement->bindValue(':title', $title);
      $statement->bindValue(':image', $imagePath);
      $statement->bindValue(':description', $description);
      $statement->bindValue(':price', $price);
      $statement->bindValue(':id', $id);
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
   <title>Update a product</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
   <link rel="stylesheet" href="app.css">
</head>

<body>
   <p>
      <a href="index.php" class="btn btn-secondary">Back to products</a>
   </p>
   <h1>Update product</h1>
   <?php if (!empty($errors)) : ?>
      <div class="alert alert-danger">
         <?php foreach ($errors as $error) : ?>
            <div><?php echo $error ?></div>
         <?php endforeach ?>
      </div>
   <?php endif ?>
   <form action="" method="post" enctype="multipart/form-data">
      <?php if ($product['image']) : ?>
         <img src="<?php echo $product['image'] ?>" class="product-img-view" />
      <?php endif; ?>
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
      <button type="submit" class="btn btn-primary">Update</button>
   </form>
</body>

</html>