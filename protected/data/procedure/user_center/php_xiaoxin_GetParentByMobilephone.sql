DELIMITER $$

USE `user_center_new`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_GetParentByMobilephone`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_GetParentByMobilephone`(p_mobile VARCHAR(20))
BEGIN
	SELECT * FROM `tb_user` WHERE `mobilephone`=p_mobile AND `deleted`=0 AND `state`=1 AND (`identity`=4 OR `identity`=5) LIMIT 1; 
END$$

DELIMITER ;