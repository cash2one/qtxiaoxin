DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_getClassTeacherRealtionByTeacherPks`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_getClassTeacherRealtionByTeacherPks`(p_mobilephones TEXT, p_cid INT)
BEGIN 
 SELECT teacher FROM `tb_class_teacher_relation` WHERE FIND_IN_SET(teacher,p_mobilephones) AND deleted=0 AND cid=p_cid GROUP BY teacher;
END$$

DELIMITER ;