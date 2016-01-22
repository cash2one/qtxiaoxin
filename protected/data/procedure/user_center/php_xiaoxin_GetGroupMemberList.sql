DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_GetGroupMemberList`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_GetGroupMemberList`(p_gid INT)
BEGIN
	SELECT 
		`tb_group_member`.`gid`			AS `gid`,
		`tb_group_member`.`member`		AS `member`,
		`tb_group_member`.`state` 		AS `state`,
		`tb_user`.`name`			AS `name`
	FROM 	`tb_group_member` LEFT JOIN `tb_user`
		ON (`tb_group_member`.`member`=`tb_user`.`userid` AND `tb_user`.`deleted`=0)
	WHERE `tb_group_member`.`gid`=p_gid AND `tb_group_member`.`deleted`=0;
END$$

DELIMITER ;