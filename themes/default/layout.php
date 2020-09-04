<?php
$ci = $this->_ci;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

        <!--Mete Block -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!--Mete Block -->

        <title>Administrator Login</title>          

        <!-- CSS Block -->
        <?php echo add_css(array('style.default', 'developer-style')); ?> 

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->

        <!-- CSS Block -->

        <!-- Script Block -->
        <?php echo add_js(array('jquery-1.10.2.min')); ?>  
        <script type="text/javascript">
            function hide_msg() {
                $('#error_msg').hide();
            }
        </script>
        <!-- Script Block -->

    </head>
    <body class="signin">

        <!-- Preloader -->
        <div id="preloader">
                <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
            </div>

        <?php echo $this->content(); ?>
    </body>
</html>