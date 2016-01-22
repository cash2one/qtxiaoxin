
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


def class_receiver(user_conn,v):
	receivers = []
	student_num,students = execute_sql(user_conn,"select t.student as student from tb_class_student_relation t left join tb_user u on t.student=u.userid where t.cid in(" + v + ") and t.deleted=0 and t.state=1 and u.deleted=0") #获取班级id下的学生
	student_pks = [str(s['student']) for s in students]
	sids = ','.join(student_pks)
	
	#找监护人
	if(len(student_pks)>0):
		guard_num,guards = execute_sql(user_conn,"SELECT tb_guardian.child,GROUP_CONCAT(tb_user.userid) as family,GROUP_CONCAT(tb_user.mobilephone) AS mobiles FROM tb_guardian LEFT JOIN tb_user ON (tb_guardian.guardian=tb_user.userid) WHERE tb_guardian.child IN ("+sids+") AND tb_guardian.deleted=0 AND tb_user.deleted=0 GROUP BY tb_guardian.child")
		for g in guards:
			receivers.append({'receiver':g['child'],'guardian':g['family'],'mobiles':g['mobiles']})
	return receivers

def group_receiver(user_conn,v):
	receivers = []
	group_pks = v.split(',')
	for g in group_pks:
		group = fetchone_sql(user_conn,"select type from tb_group where gid="+str(g))
		member_num,members = execute_sql(user_conn,"select member from tb_group_member where gid =" + str(g) + " and deleted=0 ")
		if group:
			if(group['type']==0):
				for m in members:
					guard_num,guards = execute_sql(user_conn,"SELECT tb_guardian.child,GROUP_CONCAT(tb_user.userid) as family,GROUP_CONCAT(tb_user.mobilephone) AS mobiles FROM tb_guardian LEFT JOIN tb_user ON (tb_guardian.guardian=tb_user.userid) WHERE tb_guardian.child IN (" + str(m['member']) + ") AND tb_guardian.deleted=0 AND tb_user.deleted=0 GROUP BY tb_guardian.child")
					for g in guards:
						receivers.append({'receiver':g['child'],'guardian':g['family'],'mobiles':g['mobiles']})
			else:
				for m in members:
					try:
						teacher = fetchone_sql(user_conn,"select * from tb_user where deleted=0 AND  userid="+str(m['member']))
						receivers.append({'receiver':m['member'],'guardian':m['member'],'mobiles':teacher['mobilephone']})
					except:
						continue
	return receivers

def grade_receiver(user_conn,v,sid):
	receivers = []
	grade_pks = v.split(',')
	for gid in grade_pks:
		grade = fetchone_sql(user_conn,"select * from tb_grade where gid="+str(gid))
		#print(grade)
		year = int(time.strftime('%Y', time.localtime()))
		month = int(time.strftime('%m', time.localtime()))
		day = int(time.strftime('%d', time.localtime()))
		if(grade and 'age' in grade):
			grade_year = year-int(grade['age'])
		else:
			continue
		ageyear = grade_year-1 if (month<8 or (month==8 and day<25)) else grade_year
		class_num,classes = execute_sql(user_conn,"select cid from tb_class where sid="+ str(sid) +" and year=" + str(ageyear) + " and stid=" + str(grade['stid']) + "  and deleted=0")
		class_pks = [str(c['cid']) for c in classes]
		class_ids = ','.join(class_pks)
		if(len(class_pks)):
			student_num,students = execute_sql(user_conn,"select student from tb_class_student_relation where cid in(" + class_ids + ") and deleted=0 and state=1")
			student_pks = [str(s['student']) for s in students]
			sids = ','.join(student_pks)
			
			#找监护人
			if(len(student_pks)>0):
				guard_num,guards = execute_sql(user_conn,"SELECT tb_guardian.child,GROUP_CONCAT(tb_user.userid) as family,GROUP_CONCAT(tb_user.mobilephone) AS mobiles FROM tb_guardian LEFT JOIN tb_user ON (tb_guardian.guardian=tb_user.userid) WHERE tb_guardian.child IN ("+sids+") AND tb_guardian.deleted=0 AND tb_user.deleted=0 GROUP BY tb_guardian.child")
				for g in guards:
					receivers.append({'receiver':g['child'],'guardian':g['family'],'mobiles':g['mobiles']})
	return receivers

def teacher_receiver(user_conn,v,sid):
	receivers = []
	teacher_num,teachers = execute_sql(user_conn,"select tb_school_teacher_relation.teacher as teacher,tb_user.mobilephone  as mobiles from tb_school_teacher_relation left join tb_user on tb_school_teacher_relation.teacher=tb_user.userid where tb_school_teacher_relation.sid="+str(sid)+" and tb_school_teacher_relation.deleted=0 and tb_school_teacher_relation.state=1 and  tb_user.deleted=0")
	for t in teachers:
		receivers.append({'receiver':t['teacher'],'guardian':t['teacher'],'mobiles':t['mobiles']})
	return receivers

def personal_receiver(user_conn,v):
	receivers = []
	rec_pks = v.split(',')
	if(len(rec_pks)):
		for r in list(set(rec_pks)):
			recinfo = fetchone_sql(user_conn,"select * from tb_user where userid="+str(r))
			
			if(recinfo and recinfo['identity']==2):#发送对象为学生
				guard_num,guards = execute_sql(user_conn,"SELECT tb_guardian.child,GROUP_CONCAT(tb_user.userid) as family,GROUP_CONCAT(tb_user.mobilephone) AS mobiles FROM tb_guardian LEFT JOIN tb_user ON (tb_guardian.guardian=tb_user.userid) WHERE tb_guardian.child IN ("+str(r)+") AND tb_guardian.deleted=0 AND tb_user.deleted=0 GROUP BY tb_guardian.child")
				for g in guards:
					receivers.append({'receiver':g['child'],'guardian':g['family'],'mobiles':g['mobiles']})
			else:
				if(recinfo):#发送对象为老师或家长
					receivers.append({'receiver':r,'guardian':r,'mobiles':recinfo['mobilephone']})
	return receivers

def department_receiver(user_conn,v):
	receivers = []
	if(v):
		teacher_num,teachers = execute_sql(user_conn,"SELECT u.userid AS teacher,u.mobilephone AS mobiles FROM tb_school_teacher_relation AS t LEFT JOIN tb_user AS u ON (t.teacher=u.userid AND u.deleted=0) WHERE t.state=1 AND u.deleted=0 AND t.did IN ("+v+")")
		for t in teachers:
			receivers.append({'receiver':t['teacher'],'guardian':t['teacher'],'mobiles':t['mobiles']})
	return receivers


class messageThread(threading.Thread):  
	def __init__(self, name,num):  
		threading.Thread.__init__(self)  
		self.t_name = name
		self.t_num = num
		
	def run(self):
		
		while True:
			mylock.acquire()
			state = False
			thread_num = get_thread_num()
			sql = "select * from tb_notice where  state=0 and deleted=0 limit 20"
			log_sql = sql
			row_count,rows = execute_lsql(conn,sql)
			if(rows and len(rows)>0):
				for row in rows:
					try:
						uid = row['sender']
						user_conn = uid%100
					except Exception as e:
						cur=conn.cursor()
						sta=cur.execute("update tb_notice set state=2 where noticeid="+str(row['noticeid']))
						cur.close()
						#logger(e,'message')
						continue
					
					try:
						userinfo = fetchone_sql(user_conn,"select * from tb_user where userid="+str(uid))
						username = userinfo['name']
						receiver = json.loads(str(row['receiver']),strict=False)
					except Exception as e:
						cur=conn.cursor()
						sta=cur.execute("update tb_notice set state=2 where noticeid="+str(row['noticeid']))
						cur.close()
						#logger(e,'message')
						continue
					
					if(not len(receiver)):
						cur=conn.cursor()
						sta=cur.execute("update tb_notice set state=2 where noticeid="+str(row['noticeid']))
						cur.close()
						continue
					
					noticeType = row['noticetype'] #通知类型
					sendertitle = row['sendertitle']
					sid = row['sid'] #学校id
					receives = []
					for k,v in receiver.items():
						if(not v):
							continue;
						if(k=='1'): #发送对象为班级
							receives = receives + class_receiver(user_conn,v)
						if(k=='2'): #发送对象为群组
							receives = receives + group_receiver(user_conn,v)		
						if(k=='3'): #发送对象为年级
							receives = receives + grade_receiver(user_conn,v,sid)
						if(k=='4'): #发送对象为全体老师
							receives = receives + teacher_receiver(user_conn,v,sid)
						if(k=='5'): #发送对象为个人
							receives = receives + personal_receiver(user_conn,v)
						if(k=='6'): #发送对象为部门
							receives = receives + department_receiver(user_conn,v)
				
					new_reciivers = []
					for d in receives:#滤重复
						if(not d in new_reciivers):
							new_reciivers.append(d)
					
					if(len(new_reciivers)==0):#找不到接收者
						cur=conn.cursor()
						sta=cur.execute("update tb_notice set state=2 where noticeid="+str(row['noticeid']))
						cur.close()
						continue
						
					try:
						#content = row['content'].replace('\\', '\\\\')
						content = db_escape(row['content'],'%')
						insert_head = "insert into tb_notice_message(noticeid,sender,receiver,noticetype,content,sendertitle,receivertitle,sid,schoolname,uname,rguardian,sendtime,rmobilephone,evaluatetype,issendsms,platform) values "
						insert_datas = ''
						for rec in new_reciivers:
							receivertitle = row['receivertitle']
							try:
								target = fetchone_sql(user_conn,"select name from tb_user where userid="+str(rec['receiver']))
								targetname = target['name']
								if(str(rec['receiver']) == str(row['sender'])):#给自己发送
									receivertitle = targetname + "老师，您好。"
								else:
									receivertitle = receivertitle.replace('xxx', targetname)
							except Exception as e:
								receivertitle = receivertitle.replace('xxx', targetname)
								#logger(e,'message')
							evaluatetype = row['evaluatetype'] if row['evaluatetype'] else '0'
							issendsms = row['issendsms']
							insert_value = "("+str(row['noticeid'])+","+str(row['sender'])+","+str(rec['receiver'])+","+str(row['noticetype'])+",'"+str(content)+"','"+str(row['sendertitle'])+"','"+str(receivertitle)+"','"+str(row['sid'])+"','"+str(row['schoolname'])+"','"+username+"','"+str(rec['guardian'])+"','"+str(row['sendtime'])+"','"+str(rec['mobiles'])+"',"+str(evaluatetype)+","+str(issendsms)+","+str(row['platform'])+")"
							insert_datas = insert_datas+','+insert_value if insert_datas else insert_datas+insert_value
						
						if insert_datas:
							insert_sql = insert_head+insert_datas+';'
							query = insert_sql+"update tb_notice set state=1 where noticeid="+str(row['noticeid'])+";"
							cur=conn.cursor()
							sta=cur.execute('start transaction;'+query+'commit;')
							cur.close()
						else:
							cur=conn.cursor()
							sta=cur.execute("update tb_notice set state=2 where noticeid="+str(row['noticeid']))
							cur.close()
					except Exception as e:
						cur=conn.cursor()
						sta=cur.execute("update tb_notice set state=3 where noticeid="+str(row['noticeid']))
						cur.close()
						logger(e,'message')
						
			mylock.release()
			time.sleep(1)
		
def start():
	#thread_num = get_thread_num()
	thread_num = 2
	for i in range(thread_num):
		thread = messageThread('messageThread'+str(i),i)
		thread.start()
	
if __name__== '__main__':
	start()  
