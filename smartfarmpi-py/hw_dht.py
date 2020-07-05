import Adafruit_DHT as dht
from time import sleep
import text

#Set DATA pin
DHT_PIN = 4

temperature = 0
humidity = 0

def read_value():
    global humidity, temperature
    try:
        h,t = dht.read_retry(dht.DHT22, DHT_PIN)
        humidity = h   
        temperature = t
    except:
        text.error("read dht error")
        
    return humidity,temperature
    

def read_temp_value():
    read_value()
    return temperature
    
def read_humid_value():
    read_value()
    return humidity


def main():
    while True:
        h,t = read_value()
        print('Temp={0:0.1f}*C  Humidity={1:0.1f}%'.format(t,h))
        sleep(3) #Wait 5 seconds and read again

if __name__=="__main__":
   main()