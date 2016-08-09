<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="format-detection" content="telephone=no" />
    <title><?php echo $seo['pagetitle']; ?></title>
    <meta name="keywords" content="<?php echo $seo['keywords']; ?>" />
    <meta name="description" content="<?php echo $seo['description']; ?>" />
    <link rel="stylesheet" href="<?php echo STATIC_PATH; ?>css/reset.css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php echo STATIC_PATH; ?>css/style.css?t=<?php echo time()?>" type="text/css" media="all" />
    <script src="<?php echo STATIC_PATH; ?>js/jquery.js"></script>
    <script src="<?php echo STATIC_PATH; ?>js/functions.js"></script>
    <script src="<?php echo STATIC_PATH; ?>js/jquery.lazyload.min.js"></script>
    <script src="<?php echo STATIC_PATH; ?>js/cart.js"></script>
<script src="<?php echo STATIC_PATH; ?>js/validate.js"></script> 
    <script>
    	$(document).ready(function($){
            $(".lazy .img").lazyload({
                placeholder : "<?php echo STATIC_PATH; ?>images/lazy.gif",
                effect      : "fadeIn",
                threshold : 200
            });
        });
    </script>
</head>
