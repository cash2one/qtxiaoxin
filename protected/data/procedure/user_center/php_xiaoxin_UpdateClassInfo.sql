DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_UpdateClassInfo`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_UpdateClassInfo`(p_cid INT, p_name VARCHAR(50), p_info VARCHAR(1024))
BEGIN 
	DECLARE t_error INTEGER DEFAULT 0;  
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET t_error=1;  
	START TRANSACTION; 
		UPDATE `tb_class` SET `name`=p_name,`info`=p_info WHERE `cid`=p_cid;
	IF t_error = 1 THEN  
		ROLLBACK;  
        ELSE  
		COMMIT;  
        END IF;
        SELECT t_error;  
END$$

DELIMITER ;