<?php
    $Configs["DEBUG"] = false;
    require_once('config.php');
    require_once('functions.php');

    $Id = intval($_REQUEST['id']);
        
    if ($Id <= 0)
    {
        echo json_encode( array(
            'success' => false,
            'data' => 'invalid parameters'            
            ) );
        exit;
    }

    $setting = Get_Hardware_Settings($Id);

    $IP_Address = $_SERVER['REMOTE_ADDR'];

    $A = array(
        'controller_id', $Id,
        'controller_ip', $IP_Address,
        'log_time', SqlDateTime(),
        
        'moisture', floatval( $_REQUEST['moist'] ),
        'humidity', floatval( $_REQUEST['humid'] ),
        'temperature', floatval( $_REQUEST['temper'] ),
        'luminance', floatval( $_REQUEST['lux'] ),
        
        'light_status', intval( $_REQUEST['light'] ),
        'pump_status', intval( $_REQUEST['pump'] ),
        'aircon_status', intval( $_REQUEST['aircon'] ),
        'temp_status', intval( $_REQUEST['temp'] ),
        'fan_status', intval( $_REQUEST['fan'] ),
        
        
    );    

    $res = DynDb_Insert('logs', $A);

    echo json_encode( array(
        'success' => true,
        'data' => $res,
        'time' => time()
        ) );

?>