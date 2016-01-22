DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_getSchoolByPk`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_getSchoolByPk`(p_sid INT)
BEGIN 
 SELECT * FROM `tb_school` WHERE sid=p_sid;
END$$

DELIMITER ;