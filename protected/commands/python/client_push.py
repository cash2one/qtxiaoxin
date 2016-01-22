# -*- coding: utf-8 -*-
import threading
import xinge
import json
import time
import MySQLdb
import os
import logging  

DB_XIAOXIN = {'host':'192.168.1.12','port':3306,'user':'message','passwd':'aiP4j2rWSQuZkwA','db':'test_xiaoxin'}
conn = MySQLdb.Connect (host=DB_XIAOXIN['host'], port=DB_XIAOXIN['port'], user=DB_XIAOXIN['user'] ,passwd=DB_XIAOXIN['passwd'], db=DB_XIAOXIN['db'] ,charset='utf8')
conn.autocommit(True)
mylock = threading.RLock()
android_xg =  xinge.XingeApp(2100062823, 'db25ca72df75ca7b436001b8db9538bb')
ios_xg = xinge.XingeApp(2200062766, 'c9206fa64a4cb03ed712c1ea4f23ffb1')

def logger(e,ty=''):
	datestr = time.strftime('%Y%m%d',time.localtime(time.time()))
	filename = 'py_'+ty+'_'+datestr+'.log'
	if not os.path.exists(filename):
		try:
			f = open(filename, "w")
			f.close()
		except:
			filename = 'py.log'
	logger = logging.getLogger()  
	#set loghandler  
	file = logging.FileHandler(filename)  
	logger.addHandler(file)  
	formatter = logging.Formatter("%(asctime)s %(levelname)s %(message)s")  
	file.setFormatter(formatter)   
	logger.setLevel(logging.NOTSET)
	logger.info(e)


class PushThread(threading.Thread):  
    def __init__(self, name,num):  
        threading.Thread.__init__(self)  
        self.t_name = name
        self.t_num = num
    
    def run(self):
        while True:
            cursor = conn.cursor (cursorclass = MySQLdb.cursors.DictCursor)
            cursor.execute ("SELECT * FROM tb_notice_push where state=0 or state=-100 order by pushtime limit 100")
            rows = cursor.fetchall()
            if len(rows)>0:
                updatesql = ''
                for row in rows:
                    try:
                        userId = row['userid']
                        content = row['content']
                        noticetype = 1 if row['noticetype']==1 else 2
                        if row['clienttype']==1:
                            xg = android_xg
                            msg = xinge.Message()
                            msg.type = xinge.Message.TYPE_NOTIFICATION 
                            msg.title = '家庭作业' if noticetype==1 else '学校通知'
                            msg.content = content
                            msg.expireTime = 3600
                            msg.custom = {'noticeid':row['noticeid'],'noticetype':0}
                            msg.type = xinge.Message.TYPE_NOTIFICATION 
                            style = xinge.Style(1, 1, 1, 1, 5)
                            msg.action=xinge.ClickAction(1,'',0,'cn.youteach.xxt2.activity.notify.NoticeInfoActivity','')
                            msg.style = style
                            ret = xg.PushSingleAccount(0, userId, msg,row['clienttype']-1)
                        else:
                            xg = ios_xg
                            noticeId = row['noticeid']
                            msg = xinge.MessageIOS()
                            msg.badge = 1
                            msg.sound = 'default'
                            msg.alert = content
                            msg.expireTime = 3600
                            msg.custom = {'messageid':noticeId}
                            ret = xg.PushSingleAccount(2, userId, msg, row['clienttype']-1)

                            #xg = xinge.XingeApp(2200062766, 'c9206fa64a4cb03ed712c1ea4f23ffb1')
                            #msg = xinge.MessageIOS()
                            #msg.alert = content
                            #msg.expireTime = 3600
                            # 自定义键值对，value可以是json允许的类型
                            #msg.custom = {'noticeid':row['noticeid'],'noticetype':noticetype}
                        
                        
                        print ret
                        state,m = ret
                        state = 1 if state==0 else state
                        sql = "update tb_notice_push set state="+str(state)+" where pushid="+str(row['pushid'])+";"
                        updatesql = updatesql + sql
                    except Exception as e:
                        logger(e,'push')
                
                if updatesql:
                    try:
                        cursor = conn.cursor()
                        cursor.execute(updatesql)
                    except Exception as e:
                        logger(e,'push')
            time.sleep(1)
    
def start():
    thread_num = 1
    for i in range(thread_num):
        thread = PushThread('PushThread'+str(i),i)
        thread.start()

if '__main__' == __name__:
    start()
    #xg = xinge.XingeApp(2200062766, 'c9206fa64a4cb03ed712c1ea4f23ffb1')
    #userId = '1711801'
    #noticeId = 12312312
    #msg = xinge.MessageIOS()
    #msg.badge = 1
    #msg.sound = 'default'
    #msg.alert = 'IOS Notification Test'
    #msg.expireTime = 3600
    #msg.custom = {'messageid':noticeId}
    #ret = xg.PushSingleAccount(2, userId, msg, 2)
    #print(ret)



