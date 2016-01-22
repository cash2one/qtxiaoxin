DELIMITER $$

USE `xiaoxin`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_getapproveschool`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_getapproveschool`(p_uid BIGINT)
BEGIN
		SELECT * FROM tb_approve_person WHERE uid=p_uid AND deleted=0;
END$$

DELIMITER ;