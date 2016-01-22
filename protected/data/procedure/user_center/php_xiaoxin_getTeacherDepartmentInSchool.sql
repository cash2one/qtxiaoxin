DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_getTeacherDepartmentInSchool`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_getTeacherDepartmentInSchool`(p_userid INT,p_sid INT)
BEGIN 
	IF p_userid>0 THEN
		SELECT 
			`tb_department`.`did` 				AS `did`,
			`tb_department`.`name`				AS `name`,
			`tb_school_teacher_relation`.`teacher`		AS `teacher`,
			`tb_school_teacher_relation`.`sid`		AS `sid`
		FROM `tb_school_teacher_relation` INNER JOIN `tb_department`
		ON (`tb_school_teacher_relation`.`did`=`tb_department`.`did`)	
		WHERE `tb_school_teacher_relation`.`sid`=p_sid AND `tb_school_teacher_relation`.`teacher`=p_userid AND `tb_department`.`sid`=p_sid AND `tb_school_teacher_relation`.`deleted`=0 AND `tb_department`.`deleted`=0;
	ELSE
	SELECT * FROM `tb_department` WHERE sid=p_sid AND deleted=0;
	END IF;
END$$

DELIMITER ;