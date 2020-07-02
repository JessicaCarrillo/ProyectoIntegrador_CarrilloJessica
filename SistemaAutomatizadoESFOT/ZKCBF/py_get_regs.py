import sys
import os
sys.path.insert(1,os.path.abspath("./pyzk"))
from zk import ZK, const
import json as simplejson
from objdict import ObjDict


conn = None
zk = ZK('172.16.5.90', port=4370, timeout=5, password=0, force_udp=False, ommit_ping=False)
try:

    conn = zk.connect()
    conn.disable_device()
    atts = conn.get_attendance()


    json_data = []
    for att in atts:
        #print(list.index(users))
        jsonatt = ObjDict()

        jsonatt.uid=att.uid
        jsonatt.badgennumber=att.user_id
        jsonatt.timestamp = str(att.timestamp)
        jsonatt.status = att.status
        jsonatt.punch = att.punch

        json_data.append(jsonatt)

    conn.enable_device()
    print(simplejson.dumps(json_data))


except Exception as e:
    print ("Process terminate: "+format(e))
    #print ("Process terminate : {}".format(e))
finally:
    if conn:
        conn.disconnect()