DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_ChangeClassRelationState`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_ChangeClassRelationState`(p_id INT, p_state INT, p_type VARCHAR(20))
BEGIN 
	DECLARE p_cid INT;
	DECLARE p_s INT;
	DECLARE t_error INTEGER DEFAULT 0;  
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET t_error=1;
	
	START TRANSACTION; 
		IF p_type='teacher' THEN
			SELECT cid,state INTO p_cid,p_s FROM tb_class_teacher_relation WHERE id=p_id;
			UPDATE `tb_class_teacher_relation` SET `state`=p_state WHERE id=p_id;
			IF (p_state=1) AND (p_s!=1) THEN
				UPDATE tb_class SET teachers=teachers+1 WHERE cid=p_cid;
			END IF;
		ELSE
			SELECT cid,state INTO p_cid,p_s FROM tb_class_student_relation WHERE id=p_id;
			UPDATE `tb_class_student_relation` SET `state`=p_state WHERE id=p_id;
			IF (p_state=1) AND (p_s!=1) THEN
				UPDATE tb_class SET total=total+1 WHERE cid=p_cid;
			END IF;
		END IF;
		
	IF t_error = 1 THEN  
		ROLLBACK;  
        ELSE  
		COMMIT;  
        END IF;
        SELECT t_error;  
END$$

DELIMITER ;