import sys, os
import datetime, time, schedule
import text 
import webservice, setup
import hardware

controller_id = 1

#webservice.server_url = "http://127.0.0.1/smartfarmpi"
webservice.server_url = "http://smartfarmpi.host.imakeservice.com"

def Setup_Default_Settings():
    new_settings = webservice.LoadSettingData(controller_id)
    if (new_settings):
        text.writeln("Setup Default Settings")

        changed = setup.ChangeSettings(new_settings)
        if (changed) :
            text.writeln("New Settings:" + str(new_settings))

        text.writeln("Current Settings:" + str(setup.current_settings))

timer_pending = 0
def Timer_Settings_Start(data):
    global timer_pending  
    timer_pending += 1
    settings = data
    timer_name = settings["timer_name"]

    text.writeln("Timer Start: " + timer_name)

def Timer_Settings_Stop(data):
    global timer_pending  
    timer_pending -= 0
    settings = data
    timer_name = settings["timer_name"]

    text.writeln("Timer Stop: " + timer_name)
    if (timer_pending == 0):
        Setup_Default_Settings()





last_settings_changed = datetime.datetime.now()

def Check_Settings_Changed():
    global last_settings_changed    
    try:
        time = webservice.LoadSettingChanged(controller_id)
        if (time):
            changed = False
            settings_changed = datetime.datetime.strptime(time, "%Y-%m-%d %H:%M:%S")

            text.writeln("Check Settings Changes: " + str(settings_changed) + " " + str(last_settings_changed) )

            if (settings_changed != last_settings_changed):
                last_settings_changed = settings_changed
                changed = True
                Setup_Default_Settings()


    except:
        text.error("Check Settings Changes Error " + sys.exc_info()[0])
        
def Update_Hardware_Status():
    try:
        data = {}

        data["moist"] = hardware.Get_Moisture_Status()
        data["humid"] = hardware.Get_Humidity_Status()
        data["temper"] = hardware.Get_Temperature_Status()
        data["lux"] = hardware.Get_Luminance_Status()

        data["light"] = hardware.Get_Light_Status()
        data["pump"] = hardware.Get_Pump_Status()
        data["aircon"] = hardware.Get_Aircon_Status()
        data["temp"] = hardware.Get_Temp_Status()
        data["fan"] = hardware.Get_Fan_Status()
        
        text.writeln("Update Status: " + str(data))

        webservice.UpdateStatus(controller_id, data)

    except:
        text.error("Update Status Error " + str(sys.exc_info()[0]))





####################### MAIN #########################

msg = "Starting SmartFarm. ID=" + str(controller_id)
text.writeln(msg)
hardware.Set_Display_Message(msg)

settings = webservice.LoadSettingData(controller_id)

timers = webservice.LoadTimersData(controller_id)

if (timers) :
    for timer in timers:
        start_time = int( timer["start_time"] )
        start_duration_seconds  = int( timer["start_duration_sec"] )

        start_time_value = "%02d:%02d:00" % (start_time / 60, start_time %60)
        schedule.every().day.at(start_time_value).do(Timer_Settings_Start, data=timer)

        stop_time = start_time + (start_duration_seconds / 60)

        stop_time_value = "%02d:%02d:%02d" % (stop_time / 60, stop_time % 60, start_duration_seconds % 60)
        schedule.every().day.at(stop_time_value).do(Timer_Settings_Stop, data=timer)

        text.write("start_time: " + start_time_value + " stop_time: " + stop_time_value )

Setup_Default_Settings()


schedule.every(15).seconds.do(Check_Settings_Changed)
schedule.every(7).seconds.do(Update_Hardware_Status)

Update_Hardware_Status()

while True:
    tick = int(time.time())

    dt = datetime.datetime.fromtimestamp(tick)
    dt_seconds = (dt - dt.replace(hour=0, minute=0, second=0, microsecond=0)).total_seconds()
    dt_minutes = int(dt_seconds / 60)

    datetime_text = dt.strftime("%m/%d/%Y %H:%M:%S")
    hardware.hardware_status["time"] = tick
    hardware.hardware_status["datetime_text"] = datetime_text    
    hardware.Set_Display_Status()
    
    schedule.run_pending()
    time.sleep(1)



#res = webservice.LoadTimers(1)

#print(res)
#import schedule
