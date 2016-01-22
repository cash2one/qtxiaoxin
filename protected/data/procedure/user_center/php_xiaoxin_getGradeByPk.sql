DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_getGradeByPk`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_getGradeByPk`(p_gid INT)
BEGIN 
 SELECT * FROM `tb_grade` WHERE gid=p_gid;
END$$

DELIMITER ;