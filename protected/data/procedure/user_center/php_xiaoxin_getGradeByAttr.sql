DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_getGradeByAttr`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_getGradeByAttr`(p_age INT, p_stid INT)
BEGIN 
 SELECT * FROM `tb_grade` WHERE age=p_age AND stid=p_stid;
END$$

DELIMITER ;