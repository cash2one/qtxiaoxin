DELIMITER $$

USE `xiaoxin`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_get_application`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_get_application`(p_type INT)
BEGIN
     SELECT * FROM tb_application WHERE deleted=0 AND (`type`=0 OR  `type`=p_type);
END$$

DELIMITER ;