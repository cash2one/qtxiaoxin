DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_GetClassTeacherRealtionDeleted`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_GetClassTeacherRealtionDeleted`(p_cid INT)
BEGIN
	SELECT 
		`tb_class_teacher_relation`.`cid` 		AS cid,
		`tb_class_teacher_relation`.`id`		AS id,
		`tb_class_teacher_relation`.`creationtime`	AS creationtime,
		`tb_class_teacher_relation`.`updatetime`	AS updatetime,
		`tb_class_teacher_relation`.`state`		AS state,
		`tb_class_teacher_relation`.`sid`		AS sid,
		`tb_class_teacher_relation`.`subject`		AS `subject`,
		`tb_user`.`userid`				AS `userid`,
		`tb_user`.`name`				AS `name`,
		1						AS `type`,
		`tb_user`.`mobilephone`				AS `mobilephone`
	FROM `tb_class_teacher_relation`
	LEFT JOIN tb_user
		ON (`tb_class_teacher_relation`.`teacher`=`tb_user`.`userid`)
	WHERE `tb_class_teacher_relation`.`cid` = p_cid AND `tb_class_teacher_relation`.`deleted`=1;
END$$

DELIMITER ;