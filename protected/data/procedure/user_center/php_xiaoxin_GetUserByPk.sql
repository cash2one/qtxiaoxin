DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_GetUserByPk`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_GetUserByPk`(p_userid INT)
BEGIN
	-- 根据userid获取用户
	SELECT * FROM tb_user WHERE userid=p_userid;
    END$$

DELIMITER ;