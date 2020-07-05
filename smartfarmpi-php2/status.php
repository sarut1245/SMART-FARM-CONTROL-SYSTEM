<?php
    $Configs["DEBUG"] = false;
    require_once('config.php');
    require_once('functions.php');

    $type = trim($_REQUEST['type']);

    $Id = intval($_REQUEST['id']);
        
    if ($Id <= 0)
    {
        echo json_encode( array(
            'success' => false,
            'data' => 'invalid parameters'            
            ) );
        exit;
    }
    
    if ($type == 'timers')
    {        
        $Tb = DynDb_SelectTable("SELECT * FROM timers ");    
        echo json_encode( array(
            'success' => true,
            'data' => $Tb
            ) );
        exit;
    }

    else if ($type == 'settings')
    {    
        $data = Get_Hardware_Settings($Id);    
        echo json_encode( array(
            'success' => true,
            'data' => $data
            ) );
        exit;
    }

    else if ($type == 'changes')
    {    
        $data = Get_Hardware_Settings_Changes($Id);    
        echo json_encode( array(
            'success' => true,
            'data' => $data['time']
            ) );
        exit;
    }

    else if ($type == 'status')
    {    
        $data = Get_Hardware_Status($Id);    
        echo json_encode( array(
            'success' => true,
            'data' => $data
            ) );
        exit;
    }


    echo json_encode( array(
        'success' => false,
        'data' => 'invalid function type'
        ) );
    exit;
    
?>