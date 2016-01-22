DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_getDepartmentTeacher`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_getDepartmentTeacher`(p_did INT)
BEGIN 
	SELECT 
		`tb_school_teacher_relation`.`teacher`			AS `userid`,
		`tb_department`.`sid`					AS `sid`,
		`tb_department`.`name`					AS `dname`,
		`tb_user`.`name`					AS `name`
	FROM `tb_school_teacher_relation` LEFT JOIN `tb_department`
		ON (`tb_school_teacher_relation`.`did`=`tb_department`.`did` AND `tb_department`.`deleted`=0)
	LEFT JOIN `tb_user`
		ON (`tb_school_teacher_relation`.`teacher`=`tb_user`.`userid` AND `tb_user`.`deleted`=0)
	WHERE `tb_school_teacher_relation`.`did`=p_did AND `tb_school_teacher_relation`.`deleted`=0 AND `tb_department`.`deleted`=0 AND `tb_user`.`deleted`=0;
	
END$$

DELIMITER ;