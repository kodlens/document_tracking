<?php $__env->startSection('content'); ?>
    <stock-in-create
        prop-id="<?php echo e($id); ?>"
        prop-data='<?php echo json_encode($data, 15, 512) ?>'></stock-in-create>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\eshen\Desktop\Github\vinz_posinv\resources\views/administrator/stock-in-create.blade.php ENDPATH**/ ?>