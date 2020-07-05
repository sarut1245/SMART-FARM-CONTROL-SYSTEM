<?php
    require_once('config.php');

    function Set_Hardware_Settings($Id, $status)
    {        
        if ($Id <= 0)
            return 0;

        $A = array(
            'setting_time', SqlDateTime()
        );

        if (isset($status['light']))
        {
            $A[] = 'light_status';
            $A[] = intval($status['light']);
        }
        
        if (isset($status['pump']))
        {
            $A[] = 'pump_status';
            $A[] = intval($status['pump']);
        }
        
        if (isset($status['aircon']))
        {
            $A[] = 'aircon_status';
            $A[] = intval($status['aircon']);
        }
        
        if (isset($status['temp']))
        {
            $A[] = 'temp_status';
            $A[] = intval($status['temp']);
        }        
        
        if (isset($status['fan']))
        {
            $A[] = 'fan_status';
            $A[] = intval($status['fan']);
        }
        
        $A[] = " WHERE controller_id = {$Id} ";
        
        $res = DynDb_Update('settings', $A);

        return $res;
    }

    function Get_Hardware_Settings_Changes($Id) 
    {        
        $data = DynDb_SelectTable("SELECT setting_time FROM settings WHERE controller_id = {$Id} ORDER BY setting_id DESC LIMIT 1 ", 1);
        
        return array(
            'time' => $data['setting_time']
        );
    }

    function Get_Hardware_Settings($Id) 
    {        
        $data = DynDb_SelectTable("SELECT * FROM settings WHERE controller_id = {$Id} ORDER BY setting_id DESC LIMIT 1 ", 1);
        
        $Controller_Id = intval($data['controller_id']);
        $light = intval($data['light_status']);
        $pump = intval($data['pump_status']);
        $aircon = intval($data['aircon_status']);
        $temp = intval($data['temp_status']);
        $fan = intval($data['fan_status']);
                
        $results = array(
            'controller_id' => $Controller_Id,
            'time' => $data['setting_time'],
            'light' => $light,
            'pump' => $pump,
            'aircon' => $aircon,
            'temp' => $temp,
            'fan' => $fan
        );
        
        return $results;        
    }

    function Get_Hardware_Status($Controller_Id) 
    {        
        $data = DynDb_SelectTable("SELECT * FROM logs WHERE controller_id = {$Controller_Id} ORDER BY log_id DESC LIMIT 1 ", 1);
        
        $Controller_Id = intval($data['controller_id']);
        $moisture = floatval($data['moisture']);
        $humid = floatval($data['humid']);
        $temp = floatval($data['temperature']);
        $luminance = floatval($data['temperature']);
        
        $light = intval($data['light_status']);
        $pump = intval($data['pump_status']);
        $aircon = intval($data['aircon_status']);
        $fan = intval($data['fan_status']);
                
        $results = array(
            'controller_id' => $Controller_Id,
            'time' => $data['log_time'],
            'moisture' => $moisture,
            'humid' => $humid,
            'temperature' => $temp,
            'luminance' => $luminance,
            'light_status' => $light,
            'pump_status' => $pump,
            'aircon_status' => $aircon,
            'fan_status' => $fan
        );
        
        return $results;        
    }

?>