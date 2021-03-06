DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_GetUserByAttributes`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_GetUserByAttributes`(p_attr VARCHAR(64), p_type VARCHAR(16),p_role INT)
BEGIN
	-- 根据account获取用户
	IF (p_type = 'mobilephone') THEN
		SELECT * FROM tb_user WHERE mobilephone = p_attr AND identity=p_role AND deleted = 0;
	ELSEIF (p_type = 'email') THEN
		SELECT * FROM tb_user WHERE email = p_attr AND identity=p_role AND deleted = 0;
	ELSE
		SELECT * FROM tb_user WHERE account = p_attr AND identity=p_role AND deleted = 0;
	END IF;
    END$$

DELIMITER ;