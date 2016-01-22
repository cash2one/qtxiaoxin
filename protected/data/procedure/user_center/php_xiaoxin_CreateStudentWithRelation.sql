DELIMITER $$

USE `test_xx_user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_CreateStudentWithRelation`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_CreateStudentWithRelation`(p_mobile TEXT,p_name TEXT,p_cid INT,p_state TINYINT,p_creater BIGINT,p_version INT)
BEGIN 
	DECLARE p_count INT;
	DECLARE p_scount INT;
	DECLARE p_gcount INT;
	DECLARE p_active INT;
	DECLARE p_num INT;
	DECLARE p_uid INT;
	DECLARE p_puid INT;
	DECLARE p_suid INT;
	DECLARE p_role INT;
	DECLARE p_csid INT;
	DECLARE p_cscount INT;
	DECLARE p_csstate INT;
	DECLARE p_maxuid INT;
	DECLARE p_newuser INTEGER DEFAULT 0;  
	DECLARE t_error INTEGER DEFAULT 0;  
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET t_error=1;
	
	START TRANSACTION;
		SELECT maxID INTO p_num FROM `tb_user_maxid`  WHERE `type`=0 AND `version`=p_version;
		SELECT p_num INTO p_maxuid;
		SELECT COUNT(*),`state`,`userid`,identity  INTO p_count, p_active,p_uid,p_role FROM `tb_user` WHERE `mobilephone`=p_mobile AND `deleted`=0 LIMIT 1; 
		IF p_count<=0 THEN
			SELECT (p_num+1)*100+p_version INTO p_uid;
			SELECT (p_num+2)*100+p_version INTO p_suid;
			INSERT INTO tb_user (`userid`,`account`,`pwd`,`name`,`identity`,`mobilephone`,`state`,`version`) VALUES (p_uid,CONCAT('p',p_uid),'898f8feccceb24d003b28f1176a438af',CONCAT('用户',RIGHT(p_mobile,4)),4,p_mobile,1,p_version);
			INSERT INTO tb_user (`userid`,`account`,`pwd`,`name`,`identity`,`mobilephone`,`state`,`version`) VALUES (p_suid,CONCAT('s',p_suid),'898f8feccceb24d003b28f1176a438af',p_name,2,'',1,p_version);
			SELECT p_num+2 INTO p_maxuid;
			UPDATE `tb_user_maxid` SET maxID=p_maxuid  WHERE `type`=0 AND `version`=p_version;
			INSERT INTO `tb_class_student_relation` (cid,student,state,creater) VALUES( p_cid,p_suid,p_state,p_creater);
			IF p_state=1 THEN 
				UPDATE `tb_class` SET total=total+1 WHERE cid=p_cid;
			END IF;
			INSERT INTO `tb_guardian` (child,guardian,main) VALUES (p_suid,p_uid,1);
			SELECT p_uid INTO p_newuser;
		ELSE
			IF p_role<>4 AND p_role<>5 THEN
				UPDATE `tb_user` SET identity=5 WHERE userid=p_uid;
			END IF;
			
			IF p_active!=1 THEN 
				UPDATE `tb_user` SET state=1 WHERE userid=p_uid;
			END IF;
			
			SELECT COUNT(`tb_guardian`.`child`),`tb_guardian`.`guardian`,`tb_guardian`.`child` INTO p_scount,p_puid,p_suid 
			FROM `tb_guardian` LEFT JOIN `tb_user` ON  (`tb_user`.`userid`=`tb_guardian`.`child` AND `tb_user`.`identity`=2 AND `tb_user`.`deleted`=0)
			WHERE `tb_guardian`.`guardian`=p_uid AND `tb_guardian`.`deleted`=0 AND `tb_user`.`name`=p_name AND `tb_user`.`identity`=2 AND `tb_user`.`deleted`=0 LIMIT 1;
			IF p_scount<=0 THEN 
				SELECT (p_num+1)*100+p_version INTO p_suid;
				INSERT INTO tb_user (`userid`,`account`,`pwd`,`name`,`identity`,`mobilephone`,`state`,`version`) VALUES (p_suid,CONCAT('s',p_suid),'898f8feccceb24d003b28f1176a438af',p_name,2,'',1,p_version);
				SELECT p_num+1 INTO p_maxuid;
				UPDATE `tb_user_maxid` SET maxID=p_maxuid WHERE `type`=0 AND `version`=p_version;
				INSERT INTO `tb_guardian` (child,guardian) VALUES (p_suid,p_uid);
			ELSE 
				UPDATE `tb_user` SET state=1 WHERE userid=p_suid;
			END IF;
			
			SELECT COUNT(*),`id`,`state`  INTO p_cscount,p_csid,p_csstate  FROM `tb_class_student_relation` WHERE `student`=p_suid AND `deleted`=0 AND `cid`=p_cid; 
			IF p_cscount<=0 THEN 
				INSERT INTO `tb_class_student_relation` (cid,student,state,creater) VALUES (p_cid,p_suid,p_state,p_creater);
				IF p_state=1 THEN 
					UPDATE `tb_class` SET total=total+1 WHERE cid=p_cid;
				END IF;
			ELSE
				IF p_csstate!=1 THEN
					UPDATE `tb_class_student_relation` SET state=p_state,creater=p_creater WHERE id=p_csid;
					IF p_state=1 THEN 
						UPDATE `tb_class` SET total=total+1 WHERE cid=p_cid;
					END IF;
				END IF;
			END IF;
		END IF;
	-- IF t_error = 1 THEN  
-- 		ROLLBACK;  
-- 	ELSE  
-- 		COMMIT;  
--         END IF;
--         
-- 	SELECT t_error;
	
	IF t_error = 1 THEN  
		ROLLBACK;
		SELECT 0;  
	ELSE  
		COMMIT;
		IF p_count<=0 THEN
			SELECT p_newuser;
		ELSE
			SELECT 1;
		END IF;  
        END IF;
	
END$$

DELIMITER ;