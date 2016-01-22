DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_getClassByPk`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_getClassByPk`(p_cid INT)
BEGIN 
 SELECT * FROM `tb_class` WHERE cid=p_cid;
END$$

DELIMITER ;