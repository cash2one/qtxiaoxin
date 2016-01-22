DELIMITER $$

USE `xiaoxin`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_insert_message_byfixedtime`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_insert_message_byfixedtime`(fixedtimeid BIGINT)
BEGIN
DECLARE error INT DEFAULT 0;
DECLARE cnt INT DEFAULT 0;
DECLARE i INT DEFAULT 0;
DECLARE receiveName VARCHAR(100) DEFAULT '';/*收消息人名*/
DECLARE eachuid INT DEFAULT 0;
DECLARE _sender INT;
DECLARE _receivertype INT;
DECLARE _receiver TEXT;
DECLARE _noticetype INT;
DECLARE _content TEXT;
DECLARE _sendertitle VARCHAR(100);
DECLARE _receivertitle VARCHAR(100);
DECLARE _issendsms TINYINT;
DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET error=1;
SELECT sender,receivertype,receiver,noticetype,content,sendertitle,receivertitle,issendsms,state INTO @sender,@receivertype,
@receiver,@noticetype,@content,@sendertitle,@receivertitle,@issendsms,@state FROM tb_notice_fixedtime WHERE id=fixedtimeid LIMIT 1;
START TRANSACTION;
IF @sender>0 THEN 
	INSERT INTO tb_notice(sender,receivertype,receiver,noticetype,content,sendertitle,receivertitle,issendsms,state)
	VALUES(@sender,@receivertype,@receiver,@noticetype,@content,@sendertitle,@receivertitle,@issendsms,@state);
	SET @last:=(SELECT LAST_INSERT_ID());

IF @receivertype=0  THEN /* 个人*/
		  SET cnt = func_get_split_string_total(@receiver,",");
			WHILE i < cnt
				DO
					SET i = i + 1;					
					SET eachuid:=func_get_split_string(@receiver,",",i);				
					SELECT `name` INTO receiveName FROM user_center.tb_user  WHERE userid=eachuid;
					INSERT INTO tb_notice_message(noticeid,sender,sendertitle,receiver,noticetype,content,receivertitle,state)
					VALUES(@last,@sender,@sendertitle,eachuid,@noticetype,@content,REPLACE(@receivertitle,'xxx',receiveName),@state);
			END WHILE;
ELSEIF @receivertype=1 THEN /*班级 */
		  SET cnt = func_get_split_string_total(@receiver,",");
			
			WHILE i < cnt
				DO
					SET i = i + 1;					
					SET eachuid:=func_get_split_string(@receiver,",",i);								
					INSERT INTO tb_notice_message(noticeid,sender,sendertitle,receiver,noticetype,content,receivertitle,state)
					SELECT @last,@sender,@sendertitle,user_center.tb_class_student_relation.student,@noticetype,@content,REPLACE(@receivertitle,'xxx',user_center.tb_user.`name`),@state FROM 
          user_center.tb_class_student_relation INNER JOIN 
          user_center.tb_user ON user_center.tb_class_student_relation.student=user_center.tb_user.userid WHERE user_center.tb_class_student_relation.cid=eachuid AND user_center.tb_class_student_relation.state=1 AND  
          user_center.tb_class_student_relation.deleted=0  AND user_center.tb_user.state=1 AND user_center.tb_user.deleted=0;
			END WHILE;	
ELSE
      /*组，查出组的所有成员 */
			SET cnt = func_get_split_string_total(@receiver,",");
			WHILE i < cnt
				DO
					SET i = i + 1;					
					SET eachuid:=func_get_split_string(@receiver,",",i);						
					INSERT INTO tb_notice_message(noticeid,sender,sendertitle,receiver,noticetype,content,receivertitle,state)
					SELECT @last,@sender,@sendertitle,user_center.tb_group_member.member,@noticetype,@content,REPLACE(@receivertitle,'xxx',user_center.tb_user.`name`),@state FROM 
          user_center.tb_group_member INNER JOIN 
          user_center.tb_user ON user_center.tb_group_member.member=user_center.tb_user.userid WHERE user_center.tb_group_member.gid=eachuid AND user_center.tb_group_member.state=1 AND  
          user_center.tb_group_member.deleted=0  AND user_center.tb_user.state=1 AND user_center.tb_user.deleted=0;
			END WHILE;	
END IF;
END IF;

/*  删除这定时记录*/
DELETE FROM tb_notice_fixedtime WHERE id=fixedtimeid;

IF error=1 OR @last<=0 THEN 
    ROLLBACK; 
ELSE
		COMMIT;
END IF;
SELECT error;
END$$

DELIMITER ;