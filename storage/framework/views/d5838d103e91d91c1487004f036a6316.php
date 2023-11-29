

<?php $__env->startSection('main-section'); ?>
  <h1 class="text-center">
      Products Page
  </h1>
<div class="row m-2">
<form action="" class="col-3 d-flex justify-content-center align-items-center g-2">
      <div class="form-group">
        <input type="text" name="search" class="form-control" placeholder="Search by name or price" value="<?php echo e($search); ?>"/>
      </div>
      <button class="btn btn-primary">Search</button>
      <a href="<?php echo e(url('/products')); ?>">
        <button class="btn btn-danger" type="button">Reset</button>
      </a>
  </form>
</div>
 
  
    <table class="table">
    <thead class="table-dark">
      <tr>
        <th>Id</th>
        <th>Product Name</th>
        <th>Price</th>
        <th>Status</th>
        <th>Created at</th>
        <th>Updated at</th>
      </tr>
    </thead>
    <tbody>

<?php $i=1; ?>
<?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <td><?php echo e($i); ?></td>
        <td><?php echo e($product->product_name); ?></td>
        <td><?php echo e($product->product_price); ?></</td>
        <td>
            <?php if($product->status == "1"): ?>
                Active
            <?php else: ?>
                Inactive
            <?php endif; ?>
        </td>
        <td><?php echo e($product->created_at); ?></</td>
        <td><?php echo e($product->updated_at); ?></</td>
      </tr>
      <?php $i++; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
  </table>
  <div class="row">
    <?php if($products): ?>
      <?php echo e($products->links()); ?>

    <?php endif; ?>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\laravel-project\resources\views/products.blade.php ENDPATH**/ ?>