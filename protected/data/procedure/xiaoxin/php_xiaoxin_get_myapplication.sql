DELIMITER $$

USE `xiaoxin`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_get_myapplication`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_get_myapplication`(uid BIGINT)
BEGIN
     SELECT t.appid,t.`name`,t.url,t.icon FROM tb_application t INNER JOIN tb_application_config c ON t.appid=c.app WHERE c.userid=uid AND t.deleted=0 AND c.deleted=0;
END$$

DELIMITER ;