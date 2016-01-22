DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_countClassTeacher`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_countClassTeacher`(p_cid INT)
BEGIN 
 SELECT COUNT(cid) AS num FROM `tb_class_teacher_relation` WHERE cid=p_cid AND deleted=0;
END$$

DELIMITER ;