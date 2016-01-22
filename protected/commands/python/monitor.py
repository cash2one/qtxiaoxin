# -*- coding: utf-8 -*-
from __future__ import print_function
import os, sys, time
import subprocess
import memcache
from dbconfig import *
from helper import *


mc = memcache.Client(['127.0.0.1:11211'],debug=True)
MOBILES = ['18948750132','18938883430']
# VERSION = 'xiaoxin'

def restart_process(lastid,filename):
	if lastid>0:
		cache_key = 'last_'+filename+'_'+VERSION
		cache_id = mc.get(cache_key)
		print(cache_key+':'+str(cache_id))
		if str(lastid)==str(cache_id):
			try:
				p=subprocess.Popen("ps -ef|grep "+FILE_PATH+filename+".py|grep -v grep|awk '{print $2}'",stdout=subprocess.PIPE,shell=True)
				ret = int(p.stdout.readline())
			except:
				ret=None
				
			if ret:
				os.popen('kill '+str(ret))
				time.sleep(5)
				os.popen('nohup python '+FILE_PATH+filename+'.py &')
			else:
				os.popen('nohup python '+FILE_PATH+filename+'.py &')
			
			try:
				time.sleep(5)
				new_p=subprocess.Popen("ps -ef|grep "+FILE_PATH+filename+".py|grep -v grep|awk '{print $2}'",stdout=subprocess.PIPE,shell=True)
				new_ret = int(new_p.stdout.readline())
			except:
				new_ret=None
			
			if new_ret and new_ret!=ret:
				code = 'python转换脚本('+filename+')异常，已重新启动!'+Tail
			else:
				code = 'python转换脚本('+filename+')异常，重启失败!'+Tail
			try:
				smssql = ''
				for m in MOBILES:
					smssql += "CALL fn_sendSmsType('"+str(m)+"','0','"+str(code)+"','【班班】',98);"
				if smssql:
					sms_conn = get_sms_conn()
					cur=sms_conn.cursor()
					sta=cur.execute(smssql)
					cur.close()
					sms_conn.close()
			except:
				pass
		
		mc.set(cache_key,lastid)
		
def get_lastid(conn,ty):
	try:
		if ty=='message':
			notice = fetchone_lsql(conn,"SELECT noticeid FROM tb_notice WHERE state=0 AND deleted=0 ORDER BY noticeid  LIMIT 1")
			lastid = notice['noticeid']
		if ty=='notice':
			notice = fetchone_lsql(conn,"select id from tb_notice_fixedtime where  `status`=1 and sendtime<now() and deleted=0 and state=0 order by sendtime limit 1")
			lastid = notice['id']
	except:
		lastid = 0
	return lastid

if __name__== '__main__':
	try:
		conn = get_conn()
		#消息转换脚本监控
		last_message = get_lastid(conn,'message')
		restart_process(last_message,'thread_message')
		
		time.sleep(2)
		#定时发送脚本监控
		last_notice = get_lastid(conn,'notice')
		restart_process(last_notice,'thread_notice')
	except Exception as e:
		print(e)
	try:
		conn.close()
	except:
		pass