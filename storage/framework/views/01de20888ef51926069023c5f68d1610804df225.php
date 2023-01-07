<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Scripts -->
    <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>

    <!-- Fonts -->



    <!-- Styles -->
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">


    
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300&family=Ubuntu:wght@300&display=swap" rel="stylesheet">

    <style>
        html body{
            font-family: 'Roboto Slab', serif;
            font-family: 'Ubuntu', sans-serif;
        }
    </style>

</head>
<body>
    <div id="app">
        

        <navbar-component></navbar-component>

    <div>
        <?php echo $__env->yieldContent('content'); ?>
    </div>


    </div>
</body>
</html>
<?php /**PATH C:\Users\eshen\Desktop\Github\vinz_posinv\resources\views/layouts/app.blade.php ENDPATH**/ ?>