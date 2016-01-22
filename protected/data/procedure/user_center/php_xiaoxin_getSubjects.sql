DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_getSubjects`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_getSubjects`(p_sid BIGINT)
BEGIN 
	SELECT * FROM `tb_subject` WHERE schoolid=p_sid AND deleted=0;
END$$

DELIMITER ;