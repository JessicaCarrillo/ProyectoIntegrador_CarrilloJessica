
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

    id_biometrico = sys.argv[1]
    nombre = sys.argv[2]

    conn.set_user(uid=0, name=nombre, privilege=0, password='', group_id='', user_id=id_biometrico, card=0)

except Exception as e:
    print ("Process terminate: "+format(e))
    #print ("Process terminate : {}".format(e))
finally:
    if conn:
        conn.disconnect()
