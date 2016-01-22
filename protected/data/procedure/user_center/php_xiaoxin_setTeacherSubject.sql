DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_setTeacherSubject`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_setTeacherSubject`(p_id INT, p_sid INT, p_subject VARCHAR(10))
BEGIN 
	DECLARE t_error INTEGER DEFAULT 0;  
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET t_error=1;  
	START TRANSACTION;  
		UPDATE `tb_class_teacher_relation` SET sid=p_sid, `subject`=p_subject WHERE id=p_id;
	IF t_error = 1 THEN  
		ROLLBACK;  
        ELSE  
		COMMIT;  
        END IF;
        SELECT t_error;  
END$$

DELIMITER ;