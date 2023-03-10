<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$searchQuery = $_GET['search'] ?? '';

if ($searchQuery) {
   $statement = $pdo->prepare("SELECT * FROM products WHERE title LIKE :title ORDER BY create_date DESC");
   $statement->bindValue(":title", "%$searchQuery%");
} else {
   $statement = $pdo->prepare("SELECT * FROM products ORDER BY create_date DESC");
}
$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);


?>

<!doctype html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Prducts Crud App</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
   <link rel="stylesheet" href="app.css">
</head>

<body>
   <h1>Prducts Crud App</h1>
   <form>
      <div class="input-group mb-3">
         <input type="text" class="form-control" placeholder="Search for products" name="search" value="<?php echo $searchQuery ?>">
         <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit">Search</button>
         </div>
      </div>
   </form>

   <p>
      <a href="create.php" class="btn btn-success">Create new product</a>
   </p>
   <table class="table">
      <thead>
         <tr>
            <th scope="col">#</th>
            <th scope="col">Image</th>
            <th scope="col">Title</th>
            <th scope="col">Price</th>
            <th scope="col">Creation Date</th>
            <th scope="col">Action</th>
         </tr>
      </thead>
      <tbody>
         <?php foreach ($products as $i => $product) : ?>
            <tr>
               <td scope="row"><?php echo $i + 1 ?></td>
               <td><img alt="" src="<?php echo $product["image"] ?>" class="thumb" /></td>
               <td><?php echo $product["title"] ?></td>
               <td><?php echo $product["price"] ?></td>
               <td><?php echo date($product["create_date"]) ?></td>
               <td><a href="update.php?id=<?php echo $product["id"] ?>" class="btn btn-sm btn-outline-primary">Edit</a></td>
               <td>
                  <form style="display: inline-block;" action="delete.php" method="post">
                     <input type="hidden" name="id" value="<?php echo $product["id"] ?>" />
                     <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                  </form>
               </td>
            </tr>
         <?php endforeach ?>

      </tbody>
   </table>
</body>

</html>