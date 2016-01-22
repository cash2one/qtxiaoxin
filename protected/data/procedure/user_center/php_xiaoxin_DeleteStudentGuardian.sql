DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_DeleteStudentGuardian`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_DeleteStudentGuardian`(p_id INT)
BEGIN 
	DECLARE t_error INTEGER DEFAULT 0;  
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET t_error=1;
	
	START TRANSACTION; 
		UPDATE `tb_guardian` SET deleted=1 WHERE id=p_id;
		
	IF t_error = 1 THEN  
		ROLLBACK;  
        ELSE  
		COMMIT;  
        END IF;
        SELECT t_error;  
END$$

DELIMITER ;