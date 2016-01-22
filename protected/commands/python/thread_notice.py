
from __future__ import print_function
import threading
import pymysql
import json
import time
import re
from dbconfig import *
from helper import *

conn = get_conn()
mylock = threading.RLock()  

class noticeThread(threading.Thread):  
	def __init__(self, name,num):  
		threading.Thread.__init__(self)  
		self.t_name = name
		self.t_num = num
		
	def run(self):
		while True:
			mylock.acquire()
			thread_num = get_thread_num()
			sql = "select * from tb_notice_fixedtime where  `status`=1 and sendtime<now() and deleted=0 and state=0 order by sendtime limit 50"
			row_count,rows = execute_lsql(conn,sql)
			if(rows and len(rows)>0):
				for row in rows:
					try:
						#content = row['content'].replace('\\', '\\\\')
						content = db_escape(row['content'],'%')
						sql = "insert into tb_notice(sender,receiver,noticetype,content,sendertitle,receivertitle,issendsms,sid,schoolname,receivename,sendtime) values ("+str(row['sender'])+",'"+str(row['receiver'])+"',"+str(row['noticetype'])+",'"+str(content)+"','"+str(row['sendertitle'])+"','"+str(row['receivertitle'])+"',"+str(row['issendsms'])+","+str(row['sid'])+",'"+str(row['schoolname'])+"','"+str(row['receivename'])+"','"+str(row['sendtime'])+"')" 
						cur=conn.cursor()
						sta=cur.execute(sql)
						cur_update=conn.cursor()
						sta_update=cur_update.execute("update tb_notice_fixedtime set state=1 where id=" +str(row['id']))
						cur_update.close()
					except Exception as e:
						cur=conn.cursor()
						sta=cur.execute("update tb_notice_fixedtime set state=2 where id=" +str(row['id']))
						cur.close()
						logger(e,'notice')
					
			mylock.release()
			time.sleep(1)
			
	
def start():  
	thread_num = get_thread_num()
	for i in range(thread_num):
		thread = noticeThread('noticeThread'+str(i),i)
		thread.start()  

if __name__== '__main__':
	start()  
