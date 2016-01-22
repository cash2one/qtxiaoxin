DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_GetClassTeacherRealtionByAttributes`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_GetClassTeacherRealtionByAttributes`(p_cid INT, p_state INT, p_teacher INT)
BEGIN
IF p_teacher>0 THEN 
	SELECT 
		`tb_class_teacher_relation`.`cid` 		AS cid,
		`tb_class_teacher_relation`.`id`		AS id,
		`tb_class_teacher_relation`.`creationtime`	AS creationtime,
		`tb_class_teacher_relation`.`sid`		AS sid,
		`tb_class_teacher_relation`.`state`		AS state,
		`tb_class_teacher_relation`.`subject`		AS `subject`,
		`tb_user`.`userid`				AS `userid`,
		`tb_user`.`name`				AS `name`,
		`tb_user`.`mobilephone`				AS `mobilephone`,
		`tb_class`.`name`				AS `classname`,
		1						AS `type`,
		`tb_class`.`master`				AS `master`
	FROM `tb_class_teacher_relation`
	LEFT JOIN tb_user
		ON (`tb_class_teacher_relation`.`teacher`=`tb_user`.`userid` AND `tb_user`.`state`=1)
	LEFT JOIN `tb_class`
		ON (`tb_class_teacher_relation`.`cid`=`tb_class`.`cid`)
	WHERE `tb_class_teacher_relation`.`state`=p_state AND `tb_class_teacher_relation`.`deleted`=0  AND `tb_user`.`state`=1 AND `tb_user`.`deleted`=0 AND `tb_class_teacher_relation`.`teacher`=p_teacher;
ELSE
	SELECT 
		`tb_class_teacher_relation`.`cid` 		AS cid,
		`tb_class_teacher_relation`.`id`		AS id,
		`tb_class_teacher_relation`.`creationtime`	AS creationtime,
		`tb_class_teacher_relation`.`sid`		AS sid,
		`tb_class_teacher_relation`.`state`		AS state,
		`tb_class_teacher_relation`.`subject`		AS `subject`,
		`tb_user`.`userid`				AS `userid`,
		`tb_user`.`name`				AS `name`,
		1						AS `type`,
		`tb_user`.`mobilephone`				AS `mobilephone`
	FROM `tb_class_teacher_relation`
	LEFT JOIN tb_user
		ON (`tb_class_teacher_relation`.`teacher`=`tb_user`.`userid` AND `tb_user`.`state`=1)
	WHERE `tb_class_teacher_relation`.`cid` = p_cid AND `tb_class_teacher_relation`.`state`=p_state AND `tb_class_teacher_relation`.`deleted`=0  AND `tb_user`.`state`=1 AND `tb_user`.`deleted`=0;
END IF;
END$$

DELIMITER ;