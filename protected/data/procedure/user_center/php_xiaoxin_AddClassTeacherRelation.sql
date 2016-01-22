DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_AddClassTeacherRelation`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_AddClassTeacherRelation`(
	p_cid INT,
	p_teachers TEXT,
	p_state TINYINT,
	p_creater INT
)
BEGIN
	DECLARE p_count INT;
	DECLARE p_temdeleted INT;
	DECLARE p_rid INT;
	DECLARE p_i INT DEFAULT 0; 
	DECLARE p_teacher INT DEFAULT 0;
	DECLARE p_total INT DEFAULT 0;
	DECLARE t_error INTEGER DEFAULT 0;  
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET t_error=1;
	
	START TRANSACTION; 
	
	IF CHAR_LENGTH(p_teachers)>0 THEN 
		SET @count=CHAR_LENGTH(p_teachers)-CHAR_LENGTH(REPLACE(p_teachers,',','')) + 1; 
	ELSE
		SET @count=0;
	END IF;
	
	WHILE p_i<@count DO
		SET p_i=p_i+1;
		SET p_teacher = SUBSTRING_INDEX(SUBSTRING_INDEX(p_teachers,',',p_i),',',-1);
		SELECT COUNT(*),`state`,`id`  INTO p_count, p_temdeleted,p_rid  FROM tb_class_teacher_relation WHERE cid=p_cid AND teacher=p_teacher AND deleted=0 LIMIT 1; 
	
		IF p_count<=0 THEN
			INSERT INTO tb_class_teacher_relation(cid,teacher,state,creater,`subject`) VALUES (p_cid,p_teacher,p_state,p_creater,'');
			SET p_total=p_total+1;
			IF p_state=1 THEN 
				UPDATE `tb_class` SET teachers=teachers+1 WHERE cid=p_cid;
			END IF;
		ELSE 
			IF p_temdeleted>1 THEN 
				UPDATE tb_class_teacher_relation SET state=p_state,creater=p_creater WHERE id=p_rid;
				SET p_total=p_total+1;
			END IF;
		END IF;
	END WHILE;
	
	IF t_error = 1 THEN  
		ROLLBACK;  
	ELSE  
		COMMIT;  
        END IF;
        
	SELECT p_total;
 END$$

DELIMITER ;