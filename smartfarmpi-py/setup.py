import hardware
import text

current_settings = { 
    "light": 0,
    "pump": 0,
    "aircon": 0,
    "temp": 0,
    "fan": 0
 }


def ChangeSettings(new_settings):
    changed = False
        
    try:
        value = int(new_settings["light"])
        if (value != -1 and value != current_settings["light"]):
            Setting_Light(new_settings["light"])
            changed = True
    except KeyError:
        pass

    try:
        value = int(new_settings["pump"])
        if (value != -1 and value != current_settings["pump"]):
            Setting_Pump(new_settings["pump"])
            changed = True
    except KeyError:
        pass

    try:
        value = int(new_settings["aircon"])
        if (value != -1 and value != current_settings["aircon"]):
            Setting_Aircon(new_settings["aircon"])
            changed = True
    except KeyError:
        pass

    try:
        value = int(new_settings["temp"])
        if (value != -1 and value != current_settings["temp"]):
            Setting_Temp(new_settings["temp"])
            changed = True
    except KeyError:
        pass

    try:
        value = int(new_settings["fan"])
        if (value != -1 and value != current_settings["fan"]):
            Setting_Fan(new_settings["fan"])
            changed = True
    except KeyError:
        pass

    return changed

    
    


def Setting_Light(value):
    hardware.Set_Light_Status(value)
    current_settings["light"] = value
    text.writeln("Setting Light = " + str(value))

def Setting_Pump(value):
    hardware.Set_Pump_Status(value)
    current_settings["pump"] = value
    text.writeln("Setting Pump = " + str(value))

def Setting_Aircon(value):
    hardware.Set_Aircon_Status(value)
    current_settings["aircon"] = value
    text.writeln("Setting Aircon = " + str(value))

def Setting_Temp(value):
    hardware.Set_Temp_Status(value)
    current_settings["temp"] = value
    text.writeln("Setting Temp = " + str(value))

def Setting_Fan(value):
    hardware.Set_Fan_Status(value)
    current_settings["fan"] = value
    text.writeln("Setting Fan = " + str(value))

