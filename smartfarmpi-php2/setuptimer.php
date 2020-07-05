<?php 
    require_once('config.php');
    require_once('functions.php');
    require('header.php');

    $mode = $_REQUEST['mode'];
    $Id = 1;

    $Tb = DynDb_SelectTable("SELECT * FROM timers ");

?>

<div class="container">
    <h3 class="heading">ตั้งเวลาการทำงาน(Auto)</h3>

    <div class="row">
    <?php foreach($Tb as $Tr) : ?>
    <?php
        $T = $Tr['start_time'];
        $H = floor( $T / 60 );
        $M = $T % 60;
        $start_time = sprintf("%02d:%02d", $H, M);
        
        $duration  = floor( $Tr['start_duration_sec'] / 60 ) . " นาที";
        $repeating  = floor( $Tr['start_repeating_sec'] / 60 ) . " นาที";
            
    ?>
    <div class="col-sm-4">
        <div class="panel">
            <div class="panel-body">
            <h4><a href="setuptimer_edit.php?id=<?php echo $Tr['timer_id'] ?>"><?php echo $Tr['timer_name'] ?></a></h4>
            <p>Time: <?php echo $start_time  ?></p>
            <p>Dura: <?php echo $duration ?></p>
            <p>Repeat: <?php echo $repeating ?></p>
            </div>
        </div>
    </div>
    <?php endforeach ?>
        
        <div class="col-sm-4">
        <div class="panel">
            <div class="panel-body text-center">
            <a href="setuptimer_edit.php?" class="btn btn-primary">
                เพิ่มรายการ
            </a>
            </div>
            </div>
        </div>
    </div>
    
    <p class="text-center">
        <a href="index.php" class="btn btn-warning btn-sm">ย้อนกลับ</a>
    </p>
    
</div>

 
<?php   
    require('footer.php');
?>