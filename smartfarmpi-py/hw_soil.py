import RPi.GPIO as GPIO
import time
import text

PIN_MOISTURE = 26

def read_moisture_value():
    try:
        GPIO.setup(PIN_MOISTURE, GPIO.IN)
        
        value = GPIO.input(PIN_MOISTURE)
        
        return 100 - (value * 100)
    except:
        text.error("read_moisture_error")
    return -1