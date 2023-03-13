<h1>All products</h1>

<form>
   <div class="input-group mb-3">
      <input type="text" class="form-control" placeholder="Search for products" name="search" value="<?php echo $searchQuery ?>">
      <div class="input-group-append">
         <button class="btn btn-outline-secondary" type="submit">Search</button>
      </div>
   </div>
</form>

<p>
   <a href="/products/create" class="btn btn-success">Create new product</a>
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
            <td>
               <?php if ($product['image']) : ?>
                  <img alt="" src="/<?php echo $product["image"] ?>" class="thumb" />
               <?php endif ?>

            </td>
            <td><?php echo $product["title"] ?></td>
            <td><?php echo $product["price"] ?></td>
            <td><?php echo date($product["create_date"]) ?></td>
            <td><a href="/products/update?id=<?php echo $product["id"] ?>" class="btn btn-sm btn-outline-primary">Edit</a></td>
            <td>
               <form style="display: inline-block;" action="/products/delete" method="post">
                  <input type="hidden" name="id" value="<?php echo $product["id"] ?>" />
                  <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
               </form>
            </td>
         </tr>
      <?php endforeach ?>

   </tbody>
</table>