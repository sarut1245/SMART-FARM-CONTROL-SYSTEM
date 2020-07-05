
<?php 
    require_once('config.php');
    require_once('functions.php');
    require('header.php');

    $PageTitle = "จัดการตั้งเวลา";
    
    $TablePage = "setuptimer.php?";
    $EditPage = "setuptimer_edit.php?";

    $TbName = 'timers';
    $TbPrimaryKey = 'timer_id';

    if ($User == null)
        die('Please login');

	$res = 0;
	

    $func = $_REQUEST['func'];
    $mode = $_REQUEST['mode'];
    $Id = intval($_REQUEST['id']);

    if ($func == 'submit')
    {
        $name = trim( $_REQUEST['name'] );
        
        $start_time = intval( $_REQUEST['start_time'] );
        $duration = intval( $_REQUEST['duration'] );
        $repeating = intval( $_REQUEST['repeating'] );
        
        $light = intval( $_REQUEST['light_value'] );
        $pump = intval( $_REQUEST['pump_value'] );
        $aircon = intval( $_REQUEST['aircon_value'] );
        $temp = intval( $_REQUEST['temp_value'] );
        $fan = intval( $_REQUEST['fan_value'] );
        
        if ($light < 0)
            $light = -1;
        if ($pump < 0)
            $pump = -1;
        if ($aircon < 0)
            $aircon = -1;
        if ($fan < 0)
            $fan = -1;
        
        $A = array(
            'timer_name', $name,
            'start_time', $start_time,
            'start_duration_sec', $duration,
            'start_repeating_sec', $repeating,
            'light_value', $light,
            'pump_value', $pump,
            'aircon_value', $aircon,
            'temp_value', $temp, 
            'fan_value', $fan, 
            'controller_id', 1,
            'created_date', SqlDateTime(),
        );
        
        if (count($errors) == 0) 
        {              
            
            if ($mode == 'update')
            {
                $A[] = "WHERE {$TbPrimaryKey} = {$Id}";
                $res = DynDb_Update($TbName, $A);
            }

            if ($mode == '')
            {
                $res = DynDb_Insert($TbName, $A);
                if ($res > 0)
                    $Id = $res;
            }
        }
	}

    if ($func == 'delete') 
    {
        $res = DynDb_Delete($TbName, " {$TbPrimaryKey} = {$Id} ");
        if ($res)
        {
            echo "<script>window.location = '{$TablePage}'</script>";
            exit;
        }
    }




    if ($Id > 0)
    {
        $Tr = DynDb_SelectTable("SELECT * FROM {$TbName} WHERE {$TbPrimaryKey} = {$Id}", true);
        if (count($Tr) > 0)
        {
            $Tx = $Tr;
            $mode = 'update';
            $password = '';
        }
    }

    $PageTitleMode = ($mode == 'update') ? "แก้ไขรายการ" : "เพิ่มรายการใหม่";    $Tb = DynDb_SelectTable("SELECT * FROM timers ");


    $Durations = array(
        '30' => '30 วินาที',
        '60' => '1 นาที',
        '120' => '2 นาที',
        '180' => '3 นาที',
        '300' => '5 นาที',
        '600' => '10 นาที',
        '1800' => '30 นาที',
        '3600' => '1 ชั่วโมง',
        '7200' => '2 ชั่วโมง',
        '10800' => '3 ชั่วโมง',
        '21600' => '6 ชั่วโมง',
        '28800' => '8 ชั่วโมง',
        '28800' => '12 ชั่วโมง',
        '86400' => '24 ชั่วโมง',
    );

    $Times = array(
    );

    for($I = 0; $I < 1440; $I += 30 )
    {
        $M = floor($I / 60);
        $S = $I % 60;
        $Times[ $I ] = sprintf("%02d:%02d", $M, $S);
    }

    $LightValues = array('-1' => '-', '20' => 'ปิด', '1' => 'เปิด');
    $PumpValues = array('-1' => '-', '0' => 'ปิด', '1' => 'เปิด');
    $AirconValues = array('-1' => '-', '0' => 'ปิด', '1' => 'เปิด');
    $FanValues = array('-1' => '-', '20' => 'ปิด', '1' => 'เปิด');

?>

<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
        <h2 class="panel-title"><?php echo "$PageTitle - $PageTitleMode" ?></h2>
        </div>
        <div class="panel-body">

        <?php if (($mode == '') && ($res > 0)) : ?>
        <div class="alert alert-success">
          ทำการเพิ่มรายการเรียบร้อยแล้ว
        </div>
        <?php endif;?>

        <?php if (($mode == 'update') && ($res > 0)) : ?>
        <div class="alert alert-success">
          ทำการอัพเดทรายการเรียบร้อยแล้ว
        </div>
        <?php endif;?>

        <?php if (count($errors)) : ?>
        <div class="alert alert-warning">
            <?php foreach($errors as $error) : ?>
            <li><?php echo $error ?></li>
            <?php endforeach ?>
        </div>
        <?php endif;?>    

        <form class="form-horizontal" method="post" enctype="multipart/form-data">
        <input type="hidden" value="submit" name="func" />
        <input type="hidden" value="<?php echo $mode ?>" name="mode" />
        <input type="hidden" value="<?php echo $Id ?>" name="id" />

        <div class="form-group">
            <label class="col-sm-3 control-label" for="name" >Name <span class="required">*</span></label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="name" name="name" placeholder="" value="<?php echo $Tx['timer_name'] ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label" for="start_time" >เริ่มเวลา<span class="required">*</span></label>
            <div class="col-sm-3">
                <?php echo MakeSelect('start_time', $Times, $Tx['start_time']) ?>
            </div>
            <label class="col-sm-1 control-label" for="start_duration" >ระยะเวลา</label>
            <div class="col-sm-3">
                <?php echo MakeSelect('duration', $Durations, $Tx['start_duration_sec']) ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label" for="repeating" >ทำงานซ้ำ<span class="required">*</span></label>
            <div class="col-sm-3">
                <?php echo MakeSelect('repeating', $Durations, $Tx['start_repeating_sec']) ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label" for="light_value" >ตั้งค่าไฟ</label>
            <div class="col-sm-6">
                <?php echo MakeSelect('light_value', $LightValues, $Tx['light_value']) ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label" for="pump_value" >ตั้งค่าปั้ม</label>
            <div class="col-sm-6">
                <?php echo MakeSelect('pump_value', $PumpValues, $Tx['pump_value']) ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label" for="aircon_value" >ตั้งค่าระบบปรับอากาศ</label>
            <div class="col-sm-6">
                <?php echo MakeSelect('aircon_value', $AirconValues, $Tx['aircon_value']) ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label" for="temp_value" >ตั้งอุณหภูมิ</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="temp_value" name="temp_value" placeholder="" value="<?php echo $Tx['temp_value'] ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label" for="fan_value" >ตั้งค่าพัดลม</label>
            <div class="col-sm-6">
                <?php echo MakeSelect('fan_value', $FanValues, $Tx['fan_value']) ?>
            </div>
        </div>
            
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" name="func" value="submit" class="btn btn-primary" onclick="return confirm('ยืนยันข้อมูลทั้งหมด ?')">บันทึก</button>
                <a href="<?php echo $TablePage ?>" class="btn btn-warning">ยกเลิก</a>            
                <button type="submit" name="func" value="delete" class="btn btn-danger" onclick="return confirm('ยืนยันการลบข้อมูลทั้งหมด ?')">ลบรายการ</button>

            </div>
        </div>
        </form>


    </div>
    </div>
</div>

 


<?php   
    require('footer.php');
?>