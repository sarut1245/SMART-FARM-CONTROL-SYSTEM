import hardware

data = {}

data["moist"] = hardware.Get_Aircon_Status()
data["humid"] = hardware.Get_Humidity_Status()
data["temper"] = hardware.Get_Temperature_Status()
data["lux"] = hardware.Get_Luminance_Status()

#data["light"] = hardware.Get_Light_Status()
#data["pump"] = hardware.Get_Pump_Status()
#data["aircon"] = hardware.Get_Aircon_Status()
#data["temp"] = hardware.Get_Temp_Status()
#data["fan"] = hardware.Get_Fan_Status()

print("Update Status: " + str(data))
