DELIMITER $$

USE `test_xx_user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_getOrCreateTeacherByMobilephone`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_getOrCreateTeacherByMobilephone`(p_mobile VARCHAR(20),p_name VARCHAR(50),p_password VARCHAR(50),p_version INT,p_sid INT)
BEGIN
	DECLARE p_count INT;
	DECLARE p_sch INT;
	DECLARE p_schid INT;
	DECLARE p_rid INT;
	DECLARE p_num INT;
	DECLARE p_uid INT;
	DECLARE p_role INT;
	DECLARE p_maxuid INT;
	DECLARE t_error INTEGER DEFAULT 0;  
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET t_error=1;
	
	START TRANSACTION; 
	
	SELECT COUNT(*),`userid`,identity  INTO p_count,p_uid,p_role  FROM tb_user WHERE mobilephone=p_mobile AND deleted=0 LIMIT 1; 
	IF p_count<=0 THEN
		/*创建用户 */
		SELECT maxID INTO p_num FROM `tb_user_maxid` WHERE `type`=0 AND `version`=p_version;
		SELECT (p_num+1)*100+p_version INTO p_uid;
		INSERT INTO tb_user (`userid`,`account`,`pwd`,`name`,`identity`,`mobilephone`,`state`,`version`) VALUES (p_uid,CONCAT('t',p_uid),p_password,p_name,1,p_mobile,1,p_version);
		SELECT p_num+1 INTO p_maxuid;
		UPDATE `tb_user_maxid` SET maxID=p_maxuid  WHERE `type`=0 AND `version`=p_version;
		
	ELSE
		IF p_role=1 OR p_role=5 THEN
			UPDATE tb_user SET state=1 WHERE userid=p_uid;
		ELSE
			UPDATE tb_user SET state=1,identity=5 WHERE userid=p_uid;
		END IF;
	END IF;
	
	IF p_sid>0 THEN
		SELECT COUNT(*),`id` INTO p_sch,p_schid FROM tb_school_teacher_relation WHERE teacher=p_uid AND sid=p_sid AND deleted=0;
		IF p_sch<=0 THEN
			INSERT INTO tb_school_teacher_relation (sid,teacher,state) VALUES (p_sid,p_uid,1);
		END IF;
	END IF;
	
	IF t_error = 1 THEN  
		ROLLBACK;
		SELECT 0;  
	ELSE  
		COMMIT;
		IF p_count<=0 THEN
			SELECT p_uid;
		ELSE
			SELECT 1;
		END IF;  
        END IF;
        
	
 END$$

DELIMITER ;