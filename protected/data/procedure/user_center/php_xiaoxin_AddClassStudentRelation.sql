DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_AddClassStudentRelation`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_AddClassStudentRelation`(
	p_cid INT,
	p_students TEXT,
	p_state TINYINT,
	p_creater INT
)
BEGIN
	DECLARE p_count INT;
	DECLARE p_temdeleted INT;
	DECLARE p_rid INT;
	DECLARE p_i INT DEFAULT 0; 
	DECLARE p_student INT DEFAULT 0;
	DECLARE p_total INT DEFAULT 0;
	DECLARE t_error INTEGER DEFAULT 0;  
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET t_error=1;
	
	START TRANSACTION; 
	
	IF CHAR_LENGTH(p_teachers)>0 THEN 
		SET @count=CHAR_LENGTH(p_students)-CHAR_LENGTH(REPLACE(p_students,',','')) + 1; 
	ELSE
		SET @count=0;
	END IF;
	
	WHILE p_i<@count DO
		SET p_i=p_i+1;
		SET p_student = SUBSTRING_INDEX(SUBSTRING_INDEX(p_students,',',p_i),',',-1);
		SELECT COUNT(*),`state`,`id`  INTO p_count, p_temdeleted,p_rid  FROM tb_class_student_relation WHERE cid=p_cid AND student=p_student AND deleted=0 LIMIT 1; 
	
		IF p_count<=0 THEN
			INSERT INTO tb_class_student_relation(cid,student,state,creater) VALUES (p_cid,p_student,p_state,p_creater);
			SET p_total=p_total+1;
			IF p_state=1 THEN 
				UPDATE `tb_class` SET total=total+1 WHERE cid=p_cid;
			END IF;
		ELSE 
			IF p_temdeleted>1 THEN 
				UPDATE tb_class_student_relation SET state=0,creater=p_creater WHERE id=p_rid;
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