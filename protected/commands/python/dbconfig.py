# -*- coding: utf-8 -*-
from __future__ import print_function
import pymysql
import logging  
import math
import os
import time

#校信应用数据库链接
DB_XIAOXIN = {'host':'119.147.71.83','port':3366,'user':'dbManager','passwd':'123456','db':'xiaoxin'}
#校信测试用户数据库链接
DB_USER_09 = {'host':'119.147.71.83','port':3366,'user':'dbManager','passwd':'123456','db':'user_center'}
#校信开放注册测试用户数据库链接
DB_USER_08 = {'host':'119.147.71.83','port':3366,'user':'dbManager','passwd':'123456','db':'user_center'}
#渠道商用户数据库链接
DB_USER_04 = {'host':'119.147.71.83','port':3366,'user':'dbManager','passwd':'123456','db':'user_center'}
#成都数字学校用户数据库链接
DB_USER_03 = {'host':'119.147.71.83','port':3366,'user':'dbManager','passwd':'123456','db':'user_center'}
#校信用户数据库链接
DB_USER_01 = {'host':'119.147.71.83','port':3366,'user':'dbManager','passwd':'123456','db':'user_center'}
#短息发送数据库链接
DB_SMS = {'host':'119.147.71.78','port':3306,'user':'site','passwd':'bYscX0kFiTGzeUyNeexTFDSa2','db':'xw_sms'}

FILE_PATH = '/data/www/xiaoxin/protected/commands/python/'
Tail = '(校信测试)'
VERSION = 'qtxiaoxinold'