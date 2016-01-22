DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_activeverify`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_activeverify`(p_code VARCHAR(20),p_password VARCHAR(20),p_type INT)
BEGIN
		SELECT * FROM tb_cdkey WHERE cdkey=p_code AND PASSWORD=p_password AND TYPE=p_type;
END$$

DELIMITER ;