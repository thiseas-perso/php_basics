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
   <button type="submit" class="btn btn-primary">Submit</button>
</form>