<?php 
    require_once('config.php');
    require_once('functions.php');
    require('header.php');

    $mode = $_REQUEST['mode'];
    $Id = 1;

    $status = Get_Hardware_Status($Id);

    $moisture = intval($status['moisture']);
    $temperature = intval($status['temperature']);
    $luminance = intval($status['luminance']);
    $aircon = intval($status['aircon']);    
    $fan = intval($status['temperature']);

    if (($mode == 'update') && isset($_REQUEST['light']))
    {
        $value = intval($_REQUEST['light']);
        Set_Hardware_Settings($Id, array(
            'light' => $value,
        ));
    }

    if (($mode == 'update') && isset($_REQUEST['temp']))
    {
        $value = intval($_REQUEST['temp']);
        Set_Hardware_Settings($Id, array(
            'temp' => $value,
        ));
    }

    if (($mode == 'update') && isset($_REQUEST['aircon']))
    {
        $value = intval($_REQUEST['aircon']);
        Set_Hardware_Settings($Id, array(
            'aircon' => $value,
        ));
    }

    if (($mode == 'update') && isset($_REQUEST['pump']))
    {
        $value = intval($_REQUEST['pump']);
        Set_Hardware_Settings($Id, array(
            'pump' => $value,
        ));
    }

    if (($mode == 'update') && isset($_REQUEST['fan']))
    {
        $value = intval($_REQUEST['fan']);
        Set_Hardware_Settings($Id, array(
            'fan' => $value,
        ));
    }

    // load current setting
    $setting = Get_Hardware_Settings($Id);

    $aircon = $setting['aircon'];
    $light = $setting['light'];
    $pump = $setting['pump'];
    $fan = $setting['fan'];

?>
<div class="">
    <h3 class="heading">Manual Setup</h3>
    
    <div class="">
    <div class="col-xs-6">
        <div class="rounding">
        <div class="rounding-inner">
        <p>Date:    </p>
        <p><?php echo FormatDate($status['time']) ?></p>
        </div>
        </div>
    </div>
    <div class="col-xs-6">
        <div class="rounding">
        <div class="rounding-inner">
        <p>Time:</p>
        <p><?php echo FormatTime($status['time']) ?></p>
        </div>
        </div>
    </div>
    </div>    
    
    <div class="">
        <div class="rounding" style="background-color: #ffd760;">
        <div class="rounding-inner clearfix">
            <h4>ระบบปรับอากาศ</h4>
            <div class="col-xs-6">
                <?php if ($aircon) : ?>
                <a href="?&mode=update&aircon=0" class="btn-link"><img src="images/poweron_sm.png" /></a> ON
                <?php else: ?>
                <a href="?&mode=update&aircon=1" class="btn-link"><img src="images/poweroff_sm.png" /></a> OFF
                <?php endif ?>
                
                <?php echo $temperature; ?> &deg;C
            </div>
            <div class="col-xs-6">
                <form action="#" method="post" enctype="multipart/form-data">
                <input type="hidden" name="mode" value="update" />
                <input type="text" id="temp" name="temp" value="<?php echo $setting['temp']; ?>" data-type="number" class="form-control spinner" /> &deg;C
                
                    <div>
                <a href="#" onclick="increase_value('temp', 0, 40, 1)" class="btn-link">
                    <img src="images/up_sm.png" />
                </a>
                <a href="#" onclick="increase_value('temp', 0, 40, -1)" class="btn-link">
                    <img src="images/dn_sm.png" />
                </a>
                <button type="submit" class="btn-link" name="mode" value="update">
                    <img src="images/checkmark_sm.png" />
                </button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
    <div class="">
        <div class="rounding" style="background-color: #fff860;">
        <div class="rounding-inner clearfix">
            <h4>แสงไฟ</h4>
            <div class="col-xs-6">
                <?php if ($light) : ?>
                <a href="?&mode=update&light=0" class="btn-link"><img src="images/poweron_sm.png" /></a> ON
                <?php else: ?>
                <a href="?&mode=update&light=100" class="btn-link"><img src="images/poweroff_sm.png" /></a> OFF
                <?php endif ?>                
            </div>
            <div class="col-xs-6">                
                <input type="text" id="light" name="light" value="<?php echo $luminance; ?>" data-type="number" class="form-control spinner"  /> lux
            </div>
        </div>
        </div>
    </div>
    <div class="">
        <div class="col-xs-6">
            <div class="rounding" style="background-color: #60ffe7;">
            <div class="rounding-inner clearfix">
            <h4>รถน้ำ</h4>
            <div class="">
                <?php if ($pump) : ?>
                <a href="?&mode=update&pump=0" class="btn-link"><img src="images/poweron_sm.png" /></a> ON
                <?php else: ?>
                <a href="?&mode=update&pump=1" class="btn-link"><img src="images/poweroff_sm.png" /></a> OFF
                <?php endif ?>                
            </div>
            </div>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="rounding" style="background-color: #aa60ff;">
            <div class="rounding-inner clearfix">
            <h4>พัดลมระบาย</h4>
            <div class="">
                <?php if ($fan) : ?>
                <a href="?&mode=update&fan=0" class="btn-link"><img src="images/poweron_sm.png" /></a> ON
                <?php else: ?>
                <a href="?&mode=update&fan=1" class="btn-link"><img src="images/poweroff_sm.png" /></a> OFF
                <?php endif ?>                
            </div>
            </div>
            </div>
        </div>
    </div>
</div>


<div class="">
</div>

<script>
    function increase_value(id, min, max, val) {
        var el = document.getElementById(id); 
        var v = parseInt(el.value);
        if (v + val >= max)
            el.value = max;
        else if (v + val <= min)
            el.value = min;
        else if (v + val >= min && v + val <= max)
            el.value = v + val;
    }
</script>
     
<script language="javascript">
setTimeout(function(){
   window.location.reload(1);
}, 45000);
</script>
<?php   
    require('footer.php');
?>