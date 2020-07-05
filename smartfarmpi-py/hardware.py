import hw_dht, hw_lights, hw_soil, hw_power, hw_aircon, hw_lcd
import time, datetime

hardware_status = { 
    "light": 0,
    "pump": 0,
    "aircon": 0,
    "temp": 0,
    "fan": 0,
    
    "temperature": 0,
    "moisture": 0,
    "luminance": 0,
    "humidity": 0    
 }




def Get_Light_Status():
    return hardware_status["light"]

def Get_Pump_Status():
    return hardware_status["pump"]

def Get_Aircon_Status():
    return hardware_status["aircon"]

def Get_Temp_Status():
    return hardware_status["temp"]

def Get_Fan_Status():
    return hardware_status["fan"]

def Get_Temperature_Status():
    hardware_status["temperature"] = hw_dht.read_temp_value()
    return hardware_status["temperature"]

def Get_Moisture_Status():
    hardware_status["moisture"] = hw_soil.read_moisture_value()
    return hardware_status["moisture"]

def Get_Luminance_Status():
    hardware_status["luminance"] = hw_lights.read_value()
    return hardware_status["luminance"]

def Get_Humidity_Status():
    hardware_status["humidity"] = hw_dht.read_humid_value()
    return hardware_status["humidity"]


def Set_Light_Status(value):
    hw_lights.set_light_value(value)
    hardware_status["light"] = value

def Set_Pump_Status(value):
    hw_power.set_pump_value(value)
    hardware_status["pump"] = value

def Set_Aircon_Status(value):
    hw_aircon.set_aircon_value(value)
    hardware_status["aircon"] = value

def Set_Temp_Status(value):
    hw_aircon.set_temp_value(value)
    hardware_status["temp"] = value

def Set_Fan_Status(value):
    hw_power.set_fan_value(value)
    hardware_status["fan"] = value
    
    
    
lcd = hw_lcd.LCD()
lcd.backlight(1)
lcd.lcd_clear()

   
def Set_Display_Message(text):
    try:
        lcd.lcd_clear()
        lcd.lcd_display_string(text, 1, 0)
    except:
        text.error("Set_Display_Message" + sys.exc_info()[0])

def Set_Display_Status():
    try:        
        text = hardware_status["datetime_text"]
        lcd.lcd_display_string(text, 1, 0)
        
        text = "Temp: %.1d  Humi: %0.1d " % (float(hardware_status["temperature"]), float(hardware_status["humidity"]))
        lcd.lcd_display_string(text, 2, 0)    

        text = "Lumi: %.1d  Mois: %0.1d " % (float(hardware_status["luminance"]), float(hardware_status["moisture"]))
        lcd.lcd_display_string(text, 3, 0)    
        
        aircon = "Off"
        if (hardware_status["aircon"] > 0):
            aircon = "ON "
            
        fan = "Off"
        if (hardware_status["fan"] > 0):
            fan = "ON "
            
        text = "Aircon: %s Fan: %s " % (aircon, fan)
        lcd.lcd_display_string(text, 4, 0)    
    except:
        text.error("Set_Display_Status" + sys.exc_info()[0])
 


def main():
    exec(open("./app.py").read())

if __name__=="__main__":
   main()