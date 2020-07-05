import requests
import json


#server_url = "http://127.0.0.1/smartfarmpi"
#server_url = "http://smartfarmpi.host.imakeservice.com"

def Load(url) :
    try:
        res = requests.get(server_url + url)
        if res.status_code == 200:
            try:
                data = json.loads(res.content)
                if (data["success"] == True):
                    return data["data"]
            except json.decoder.JSONDecodeError:
                print("Load: Data " + url + " error.")
    except:
        print("Load: Connection " + url + " error.")
    return False 
    

def LoadSettingChanged(id):
    url = "/status.php?type=changes&id=" + str(id)
    return Load(url)


def LoadSettingData(id):
    url = "/status.php?type=settings&id=" + str(id)
    return Load(url)


def LoadTimersData(id):
    url = "/status.php?type=timers&id=" + str(id)
    return Load(url)


def UpdateStatus(id, data):
    url = server_url + "/update.php?id=" + str(id)
    data["id"] = id

    res = requests.post(url, data=data)

    if res.status_code == 200:
        data = json.loads(res.content)
        if (data["success"]):
            return True
    return False


#UpdateStatus()

#res = LoadTimers(1)

#print(res)

## บังคับให้เปิดไฟล์ app
if __name__ == "__main__":
    exec(open("app.py").read())