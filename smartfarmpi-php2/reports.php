<?php 
    require_once('config.php');
    require_once('functions.php');
    require('header.php');

    $mode = $_REQUEST['mode'];
    $Id = 1;

    if (isset($_REQUEST['date'])) : 

    $date = trim($_REQUEST['date']);

    $Tb = DynDb_SelectTable("SELECT * FROM logs WHERE DATE(log_time) = '{$date}' ORDER BY log_time ");

?>

<div class="container">
    <h3 class="heading">REPORTS</h3>
    <p>รายละเอียดวันที่ <?php echo FormatDate( $date ) ?></p>
    <table class="table">
        <thead>
        <tr>
            <th>เวลา</th>
            <th>ความชื้นดิน</th>
            <th>ความชื้นอากาศ</th>
            <th>อุณหภูมิ</th>
            <th>ความสว่าง</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($Tb as $Tr) : ?>
        <tr>
            <td><?php echo FormatTime($Tr['log_time']) ?></td>
            <td><?php echo $Tr['moisture'] ?></td>
            <td><?php echo $Tr['humidity'] ?></td>
            <td><?php echo $Tr['temperature'] ?></td>
            <td><?php echo $Tr['luminance'] ?></td>
        </tr>
        <?php endforeach ?>
        </tbody>
    </table>
    
    <p class="text-center">
        <a href="reports.php" class="btn btn-warning btn-sm">ย้อนกลับ</a>
    </p>
    
</div>


<?php else : 

    $Tb = DynDb_SelectTable("SELECT DATE(log_time) as D FROM logs GROUP BY DATE(log_time) ORDER BY D DESC ");
?>


<div class="container">
    <h3>REPORTS</h3>
    <p>เลือกดูตามวันที่</p>
    <table class="table">
        <?php foreach($Tb as $Tr) : ?>
        <tr>
            <td><a href="?date=<?php echo $Tr['D'] ?>"><?php echo $Tr['D'] ?></a></td>
        </tr>
        <?php endforeach ?>
    </table>
    <p class="text-center">
        <a href="index.php" class="btn btn-warning btn-sm">ย้อนกลับ</a>
    </p>
</div>
<?php endif ?>
     
<?php   
    require('footer.php');
?>