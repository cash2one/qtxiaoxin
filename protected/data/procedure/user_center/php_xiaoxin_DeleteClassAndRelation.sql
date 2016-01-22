DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_DeleteClassAndRelation`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_DeleteClassAndRelation`(p_cid INT)
BEGIN 
	DECLARE t_error INTEGER DEFAULT 0;  
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET t_error=1;
	
	START TRANSACTION; 
		UPDATE `tb_class_teacher_relation` SET deleted=1 WHERE cid=p_cid;
		UPDATE `tb_class` SET deleted=1 WHERE cid=p_cid;
		
	IF t_error = 1 THEN  
		ROLLBACK;  
        ELSE  
		COMMIT;  
        END IF;
        SELECT t_error;  
END$$

DELIMITER ;