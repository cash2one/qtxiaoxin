DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_AddUserGroupMember`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_AddUserGroupMember`(p_gid INT,p_userid INT)
BEGIN
	DECLARE p_lastid INT DEFAULT 0;
	DECLARE p_count INT;  
	DECLARE p_rid INT;  
	SELECT COUNT(*),`id`  INTO p_count,p_rid  FROM `tb_group_member` WHERE gid=p_gid AND member= p_userid AND deleted=0 LIMIT 1; 
	IF p_count<=0 THEN 
		INSERT INTO `tb_group_member` (`gid`,`member`) VALUES (p_gid,p_userid);
		SET p_lastid=@@IDENTITY;
		SELECT p_lastid;
	ELSE
		SELECT p_rid;
	END IF;
END$$

DELIMITER ;