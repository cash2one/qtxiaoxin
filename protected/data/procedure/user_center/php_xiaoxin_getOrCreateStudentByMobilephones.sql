DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_getOrCreateStudentByMobilephones`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_getOrCreateStudentByMobilephones`(p_mobilephones TEXT,p_names TEXT,p_cid TINYINT,p_state TINYINT)
BEGIN 
	DECLARE p_count INT;
	DECLARE p_active INT;
	DECLARE p_uid INT;
	DECLARE p_i INT DEFAULT 0; 
	DECLARE p_mobile VARCHAR(20) DEFAULT '';
	DECLARE p_name VARCHAR(20) DEFAULT '';
	DECLARE p_total INT DEFAULT 0;
	DECLARE p_num INT;
	DECLARE p_pk INT;
	DECLARE p_curid INT DEFAULT 0; 
	DECLARE p_csid INT;
	DECLARE p_csstate INT;
	DECLARE p_cscount INT;
	DECLARE t_error INTEGER DEFAULT 0;  
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET t_error=1;
	
	START TRANSACTION;
	
	SET @count=CHAR_LENGTH(p_mobilephones)-CHAR_LENGTH(REPLACE(p_mobilephones,',','')) + 1; 
	SELECT MAX(userid)DIV 100 INTO p_num FROM `tb_user`;
	WHILE p_i<@count DO
		SET p_i=p_i+1;
		SET p_mobile = SUBSTRING_INDEX(SUBSTRING_INDEX(p_mobilephones,',',p_i),',',-1);
		SELECT COUNT(*),`state`,`userid`  INTO p_count, p_active,p_uid  FROM `tb_user` WHERE `mobilephone`=p_mobile AND `deleted`=0 AND `state`=1 AND `identity`=2 LIMIT 1; 
		SET p_name = SUBSTRING_INDEX(SUBSTRING_INDEX(p_names,',',p_i),',',-1);
		
		IF p_count<=0 THEN
			
			SELECT (p_num+p_i)*100+1 INTO p_pk;
			INSERT INTO tb_user (`userid`,`account`,`pwd`,`name`,`identity`,`mobilephone`,`state`) VALUES (p_pk,p_pk,'',p_name,2,p_mobile,1);
			INSERT INTO `tb_class_student_relation` (cid,student,state) VALUES( p_cid,p_pk,p_state);
		ELSE
			IF p_active!=1 THEN 
				UPDATE `tb_user` SET state=1 WHERE userid=p_uid;
			END IF;
			UPDATE `tb_user` SET `name`=p_name WHERE userid=p_uid;
			SELECT COUNT(*),`state`,`id`  INTO p_cscount, p_csstate,p_csid  FROM `tb_class_student_relation` WHERE `student`=p_uid AND `deleted`=0 AND `cid`=p_cid; 
			IF p_cscount<=0 THEN 
				INSERT INTO `tb_class_student_relation` (cid,student,state) VALUES (p_cid,p_uid,p_state);
			ELSE
				IF p_csstate!=1 THEN 
					UPDATE `tb_class_student_relation` SET state=p_state WHERE id=p_csid;
				END IF;
			END IF;
		END IF;
		SET p_total=p_total+1;
		
	END WHILE;
	
	IF t_error = 1 THEN  
		ROLLBACK;  
		SELECT 0 INTO p_total;
	ELSE  
		COMMIT;  
        END IF;
        
	SELECT p_total;
	
END$$

DELIMITER ;