DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_DeleteUserGroup`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_DeleteUserGroup`(p_gid INT)
BEGIN 
	DECLARE t_error INTEGER DEFAULT 0;  
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET t_error=1;
	
	START TRANSACTION; 
		UPDATE `tb_group` SET deleted=1 WHERE gid=p_gid;
		UPDATE `tb_group_member` SET deleted=1 WHERE gid=p_gid;
		
	IF t_error = 1 THEN  
		ROLLBACK;  
        ELSE  
		COMMIT;  
        END IF;
        SELECT t_error;  
END$$

DELIMITER ;