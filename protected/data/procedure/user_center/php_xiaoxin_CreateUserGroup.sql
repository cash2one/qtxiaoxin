DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_CreateUserGroup`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_CreateUserGroup`(p_name VARCHAR(20),p_userid INT,p_type INT,p_sid INT,p_version INT)
BEGIN
	DECLARE p_lastid INT DEFAULT 0;  
	DECLARE p_num INT;
	DECLARE p_gid INT DEFAULT 0;
	DECLARE p_maxuid INT;
	DECLARE t_error INTEGER DEFAULT 0;  
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET t_error=1;
	
	START TRANSACTION; 
	
		SELECT maxID INTO p_num FROM `tb_user_maxid` WHERE `type`=5 AND `version`=p_version;
		SELECT (p_num+1)*100+p_version INTO p_gid;
		INSERT INTO `tb_group` (gid,`name`,`creater`,`type`,`sid`) VALUES (p_gid,p_name,p_userid,p_type,p_sid);
		SELECT p_num+1 INTO p_maxuid;
		UPDATE `tb_user_maxid` SET maxID=p_maxuid  WHERE `type`=5 AND `version`=p_version; 
	
	IF t_error=1 THEN  
		ROLLBACK;  
	ELSE  
		COMMIT;  
	END IF;
	SELECT p_gid;
END$$

DELIMITER ;