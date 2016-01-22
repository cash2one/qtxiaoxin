DELIMITER $$

USE `xiaoxin`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_getConfig`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_getConfig`(psid INT,configname VARCHAR(50))
BEGIN
		SELECT * FROM tb_config WHERE sid=psid AND `name`=configname ;
END$$

DELIMITER ;