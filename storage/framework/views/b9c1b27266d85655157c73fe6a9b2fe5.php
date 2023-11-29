<?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="conatiner">
    <?php echo $__env->yieldContent('main-section'); ?>
</div>
<?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\laravel-project\resources\views/layouts/main.blade.php ENDPATH**/ ?>