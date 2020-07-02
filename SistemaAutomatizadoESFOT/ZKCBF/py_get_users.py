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
    users = conn.get_users()


    json_data = []
    for user in users:
        #print(list.index(users))
        jsonusr = ObjDict()
        privilege = 'User'
        if user.privilege == const.USER_ADMIN:
            privilege = 'Admin'
        jsonusr.badgennumber=user.uid
        jsonusr.name = user.name
        jsonusr.privilege = privilege
        jsonusr.password = user.password
        jsonusr.group_id = user.group_id
        jsonusr.user_id = user.user_id
        json_data.append(jsonusr)

    conn.enable_device()
    print(simplejson.dumps(json_data))


except Exception as e:
    print ("Process terminate: "+format(e))
    #print ("Process terminate : {}".format(e))
finally:
    if conn:
        conn.disconnect()