import sys
import os
sys.path.insert(1,os.path.abspath("/C:/xampp/htdocs/SistemaAutomatizadoESFOT/SistemaAutomatizadoESFOT/ZKCBF/pyzk"))
from zk import ZK, const
import json as simplejson
from objdict import ObjDict

conn = None
zk = ZK('192.168.43.8', port=4370, timeout=5, password=0, force_udp=False, ommit_ping=False)
ip='192.168.0.130'
try:

    conn = zk.connect()
    conn.disable_device()
    atts = conn.get_attendance()

    json_data = []
    for att in atts:
        #print(list.index(users))
        jsonatt = ObjDict()

        jsonatt.uid=att.uid
        jsonatt.badgenumber=att.user_id
        jsonatt.checktime = str(att.timestamp)
        jsonatt.status = att.status
        jsonatt.checktype = att.punch
        jsonatt.sensorid = ip
        jsonatt.attstatus = 1
        json_data.append(jsonatt)


    conn.enable_device()
    print(simplejson.dumps(json_data))


except Exception as e:
    print ("Process terminate: "+format(e))
    #print ("Process terminate : {}".format(e))
finally:
    if conn:
        conn.disconnect()