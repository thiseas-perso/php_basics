<?php


$title = $_POST["title"];
$description = $_POST["description"];
$price = $_POST["price"];
$imagePath = '';


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
   // $foo = $bar ?? 'something';
   // $foo = isset($bar) ? $bar : 'something';

   if ($image && $image["tmp_name"]) {
      if ($product['image']) {
         unlink($product["image"]);
      }
      $imagePath = 'images/' . randomString(8) . '/' . $image['name'];
      mkdir(dirname($imagePath));
      move_uploaded_file($image['tmp_name'], $imagePath);
   }
}
