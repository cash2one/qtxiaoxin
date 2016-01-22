DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_UpdateUserInfo`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_UpdateUserInfo`(
	p_userid	BIGINT(20),
	p_name 		VARCHAR(20),
	p_sex		TINYINT,
	p_photo 	VARCHAR(256)	
)
BEGIN
	DECLARE p_count INT;
	DECLARE t_error INTEGER DEFAULT 0;  
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET t_error=1;  
	START TRANSACTION; 
		UPDATE tb_user SET `name`=p_name, `sex`=p_sex WHERE `userid`= p_userid;
		SELECT COUNT(*) INTO p_count FROM tb_user_ext WHERE userid=p_userid;
		IF p_count<=0 THEN 
			INSERT INTO `tb_user_ext` (userid,photo) VALUES (p_userid,p_photo);
		ELSE 
			UPDATE `tb_user_ext` SET photo=p_photo WHERE userid=p_userid;
		END IF;
	IF t_error = 1 THEN  
		ROLLBACK;  
        ELSE  
		COMMIT;  
        END IF;
        SELECT t_error; 
    END$$

DELIMITER ;