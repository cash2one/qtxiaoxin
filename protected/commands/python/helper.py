# -*- coding: utf-8 -*-
from __future__ import print_function
import pymysql
import logging  
import math
import os
import time
from dbconfig import *

#启动线程数
THREAD_NUM = 5

def get_thread_num():
	return THREAD_NUM

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
	#set formater  
	#formatter = logging.Formatter("%(asctime)s %(levelname)s %(message)s")  
	formatter = logging.Formatter("%(asctime)s %(levelname)s %(message)s")  
	file.setFormatter(formatter)   
	#set log level  
	logger.setLevel(logging.NOTSET)
	logger.info(e)
	#return logger

def get_conn():
	conn = pymysql.connect(host=DB_XIAOXIN['host'], port=DB_XIAOXIN['port'], user=DB_XIAOXIN['user'], passwd=DB_XIAOXIN['passwd'], db=DB_XIAOXIN['db'],charset='utf8',autocommit=True)
	return conn

def get_user_conn(version):
	if version==1:#校信用户数据库链接
		user_conn = pymysql.connect(host=DB_USER_01['host'], port=DB_USER_01['port'], user=DB_USER_01['user'], passwd=DB_USER_01['passwd'], db=DB_USER_01['db'],charset='utf8')
		return user_conn
	if version==9:
		user_conn = pymysql.connect(host=DB_USER_09['host'], port=DB_USER_09['port'], user=DB_USER_09['user'], passwd=DB_USER_09['passwd'], db=DB_USER_09['db'],charset='utf8')
		return user_conn
	if version==4:#渠道商用户数据库链接
		user_conn = pymysql.connect(host=DB_USER_04['host'], port=DB_USER_04['port'], user=DB_USER_04['user'], passwd=DB_USER_04['passwd'], db=DB_USER_04['db'],charset='utf8')
	elif version==3:#成都数字学校用户数据库链接
		user_conn = pymysql.connect(host=DB_USER_01['host'], port=DB_USER_01['port'], user=DB_USER_01['user'], passwd=DB_USER_01['passwd'], db=DB_USER_01['db'],charset='utf8')
		return user_conn
		#user_conn = pymysql.connect(host=DB_USER_03['host'], port=DB_USER_03['port'], user=DB_USER_03['user'], passwd=DB_USER_03['passwd'], db=DB_USER_03['db'],charset='utf8')
	else:#默认返回校信用户数据库链接
		user_conn = pymysql.connect(host=DB_USER_01['host'], port=DB_USER_01['port'], user=DB_USER_01['user'], passwd=DB_USER_01['passwd'], db=DB_USER_01['db'],charset='utf8')
	return user_conn

def get_trans_conn():
	conn = pymysql.connect(host=DB_MSGTRANS['host'], port=DB_MSGTRANS['port'], user=DB_MSGTRANS['user'], passwd=DB_MSGTRANS['passwd'], db=DB_MSGTRANS['db'],charset='utf8',autocommit=True)
	return conn

def get_sms_conn():
	conn = pymysql.connect(host=DB_SMS['host'], port=DB_SMS['port'], user=DB_SMS['user'], passwd=DB_SMS['passwd'], db=DB_SMS['db'],charset='utf8',autocommit=True)
	return conn

def execute_lsql(conn,sql):
	"""长链接,执行结束不关闭数据库链接"""
	cur = conn.cursor(pymysql.cursors.DictCursor)
	cur.execute(sql)
	rows = cur.fetchall()
	num_rows = int(cur.rowcount)
	cur.close()
	#conn.close()
	return num_rows,rows

def execute_sql(version,sql):
	"""短链接,执行结束关闭数据库链接"""
	try:
		conn = get_user_conn(version)
		cur = conn.cursor(pymysql.cursors.DictCursor)
		cur.execute(sql)
		rows = cur.fetchall()
		num_rows = int(cur.rowcount)
		cur.close()
		conn.close()
		return num_rows,rows
	except:
		return 0,[]

def fetchone_sql(version,sql):
	"""短链接,执行结束关闭数据库链接"""
	try:
		conn = get_user_conn(version)
		cur = conn.cursor(pymysql.cursors.DictCursor)
		cur.execute(sql)
		row = cur.fetchone()
		cur.close()
		conn.close()
		return row
	except:
		return None
	
def fetchone_lsql(conn,sql):
	"""长链接,执行结束不关闭数据库链接"""
	cur = conn.cursor(pymysql.cursors.DictCursor)
	cur.execute(sql)
	row = cur.fetchone()
	cur.close()
	return row




def db_escape(pattern,ext=''):
	"""
	Escape all the characters in pattern except ASCII letters, numbers and '_'.
	"""
	_alphanum_str = frozenset("_abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890"+str(ext))
	_alphanum_bytes = frozenset(b"_abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890")
	if isinstance(pattern, str):
		alphanum = _alphanum_str
		s = list(pattern)
		for i, c in enumerate(pattern):
			if c not in alphanum:
				if c == "\000":
					s[i] = "\\000"
				else:
					s[i] = "\\" + c
		return "".join(s)
	else:
		alphanum = _alphanum_bytes
		s = []
		esc = ord(b"\\")
		for c in pattern:
			if c in alphanum:
				s.append(c)
			else:
				if c == 0:
					s.extend(b"\\000")
				else:
					s.append(esc)
					s.append(c)
		return bytes(s)