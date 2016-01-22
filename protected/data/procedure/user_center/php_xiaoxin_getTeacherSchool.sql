DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_getTeacherSchool`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_getTeacherSchool`(p_teacher INT)
BEGIN 
SELECT 
	`tb_school_teacher_relation`.`teacher` 			AS `userid`,
	`tb_school`.`sid`					AS `sid`,
	`tb_school`.`name`					AS `name`,
	`tb_school`.`aid`					AS `aid`,
	`tb_school`.`stid`					AS `stid`
FROM `tb_school_teacher_relation`
	LEFT JOIN `tb_school`
	ON (`tb_school_teacher_relation`.`sid`=`tb_school`.`sid`)
WHERE `tb_school_teacher_relation`.`teacher`=p_teacher AND `tb_school_teacher_relation`.`deleted`=0 AND `tb_school`.`deleted`=0;

END$$

DELIMITER ;