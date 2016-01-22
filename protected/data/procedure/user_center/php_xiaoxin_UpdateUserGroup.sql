DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_UpdateUserGroup`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_UpdateUserGroup`(p_gid INT,p_name VARCHAR(100))
BEGIN
	UPDATE `tb_group` SET `name`=p_name WHERE gid=p_gid;
	SELECT p_gid;
END$$

DELIMITER ;