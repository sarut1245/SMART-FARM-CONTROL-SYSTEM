<?php
    require_once('config.php');

    if ($User == null)
    {
        header('Location: login.php');
        exit;
    }
     
    require('header.php');

    $Page = trim($_REQUEST['page']);
    if ($Page == '')
        $Page = 'users';

?>

<div class="row">
  <div class="col-sm-12">
      
    <?php 
    switch ($Page) {

      default:
        $Dest = "admin_{$Page}.php";
        if (is_file($Dest))
            require($Dest);
        break;

    }
    ?>
      
  </div>
</div>

      

<?php
    require('footer.php');
?>