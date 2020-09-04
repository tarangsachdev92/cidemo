<?php
$ci = $this->_ci;
require_once 'header.php';

//display content (the view) 
?>
<div class="main-container-middle">
    <div id="ajax_table">
        <?php echo $this->content(); ?>
    </div>
</div>
<?php require_once 'footer.php'; ?>