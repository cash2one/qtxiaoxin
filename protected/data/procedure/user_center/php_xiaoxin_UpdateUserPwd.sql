DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_UpdateUserPwd`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_UpdateUserPwd`(
	p_userid	BIGINT(20),
	p_pwd 		VARCHAR(50)	
)
BEGIN
	DECLARE t_error INTEGER DEFAULT 0;  
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET t_error=1;  
	START TRANSACTION; 
		UPDATE tb_user SET `pwd`=p_pwd WHERE `userid`= p_userid;
	IF t_error = 1 THEN  
		ROLLBACK;  
        ELSE  
		COMMIT;  
        END IF;
        SELECT t_error; 
    END$$

DELIMITER ;