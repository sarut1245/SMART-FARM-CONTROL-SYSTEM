import RPi.GPIO as GPIO
import time


PIN_PUMP = 27
PIN_FAN = 22
PIN_AIRCON = 23
PIN_LIGHT = 24

GPIO.setwarnings(False)
GPIO.cleanup()
GPIO.setmode(GPIO.BCM)

def set_pump_value(value):
    try:
        state = False
        if (value > 0):
            state = True    
        GPIO.setup(PIN_PUMP, GPIO.OUT)
        GPIO.output(PIN_PUMP, not state)
    except:
        text.error("set_pump_value " + sys.exc_info()[0])
        

def set_fan_value(value):
    try:
        state = False
        if (value > 0):
            state = True            
        GPIO.setup(PIN_FAN, GPIO.OUT)
        GPIO.output(PIN_FAN, not state)
    except:
        text.error("set_pump_value " + sys.exc_info()[0])

def set_aircon_value(value):
    try:
        state = False
        if (value > 0):
            state = True    
        GPIO.setup(PIN_AIRCON, GPIO.OUT)
        GPIO.output(PIN_AIRCON, not state)
    except:
        text.error("set_aircon_value " + sys.exc_info()[0])

def set_light_value(value):
    try:
        state = False
        if (value > 0):
            state = True    
        GPIO.setup(PIN_LIGHT, GPIO.OUT)
        GPIO.output(PIN_LIGHT, not state)
    except:
        text.error("set_aircon_value " + sys.exc_info()[0])

## for testing
def main():
    
    print("PUMP Control")
    set_pump_value(1)
    time.sleep(3)
    set_pump_value(0)
    time.sleep(1)

    print("FAN Control")
    set_fan_value(1)
    time.sleep(3)
    set_fan_value(0)
    time.sleep(1)

    print("AIRCON Control")
    set_aircon_value(1)
    time.sleep(3)
    set_aircon_value(0)
    time.sleep(1)

    print("LIGHT Control")
    set_light_value(1)
    time.sleep(3)
    set_light_value(0)
    time.sleep(1)
    GPIO.cleanup()
    

if __name__=="__main__":
    main()
