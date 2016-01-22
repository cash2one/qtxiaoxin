DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_DeleteUserGroupMember`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_DeleteUserGroupMember`(p_gid INT)
BEGIN
	UPDATE `tb_group_member` SET `deleted`=1 WHERE gid=p_gid;
	SELECT p_gid;
END$$

DELIMITER ;