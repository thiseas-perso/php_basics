<?php

namespace app\controllers;

use app\models\Product;
use app\Router;

class ProductController
{
   public static function index(Router $router)
   {
      $searchQuery = $_GET['search'] ?? '';
      $products = $router->db->getProducts($searchQuery);
      $router->renderView('products/index', [
         'products' => $products,
         'searchQuery' => $searchQuery
      ]);
   }
   public static function create(Router $router)
   {
      $errors = [];
      $productData = [
         'title' => '',
         'image' => '',
         'description' => '',
         'price' => '',

      ];

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $productData['title'] = $_POST['title'];
         $productData['description'] = $_POST['description'];
         $productData['price'] = (float)$_POST['price'];
         $productData['imageFile'] = $_FILES['image'] ?? null;

         $product = new Product;
         $product->load($productData);
         $errors = $product->save();
         if (empty($errors)) {
            header('Location: /products');
            exit;
         }
      }

      $router->renderView('products/create', [
         'product' => $productData,
         'errors' => $errors
      ]);
   }
   public static function update(Router $router)
   {
      $id = $_GET['id'] ?? null;
      $errors = [];
      if (!$id) {
         header('Location: /products');
      }

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $productData['title'] = $_POST['title'];
         $productData['description'] = $_POST['description'];
         $productData['price'] = (float)$_POST['price'];
         $productData['imageFile'] = $_FILES['image'] ?? null;
         $productData['id'] = $id;
         $product = new Product;
         $product->load($productData);
         $errors = $product->save();
         if (empty($errors)) {
            header('Location: /products');
            exit;
         }
      }

      $productData = $router->db->getProductById($id);
      $router->renderView('products/update', [
         'product' => $productData,
         'errors' => $errors,
      ]);
   }

   public static function delete(Router $router)
   {
      $id = $_POST['id'] ?? null;
      if (!$id) {
         header('Location: /products');
      }
      $router->db->deleteProduct($id);
      header('Location: /products');
   }
}
