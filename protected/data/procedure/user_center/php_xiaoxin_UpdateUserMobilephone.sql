DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_UpdateUserMobilephone`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_UpdateUserMobilephone`(
	p_userid	BIGINT(20),
	p_mobile 	VARCHAR(20)	
)
BEGIN
	DECLARE p_role INT;
	DECLARE p_count INT;
	DECLARE t_error INTEGER DEFAULT 0;  
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET t_error=1;  
	START TRANSACTION; 
		SELECT `identity` INTO p_role  FROM `tb_user` WHERE `userid`=p_userid;
		SELECT COUNT(*) INTO p_count FROM `tb_user` WHERE `identity`=p_role AND `deleted`=0 AND `mobilephone`=p_mobile AND `userid`!=p_userid;
		IF p_count=0 THEN 
			UPDATE tb_user SET `mobilephone`=p_mobile WHERE `userid`= p_userid;
		END IF;
	IF t_error = 1 THEN  
		ROLLBACK;  
        ELSE  
		COMMIT;  
        END IF;
        IF p_count>0 THEN 
		SELECT 2;
        ELSE
		SELECT t_error; 
	END IF;
    END$$

DELIMITER ;