DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_GetClassStudentRealtionByAttributes`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_GetClassStudentRealtionByAttributes`(p_cid INT, p_state INT, p_student INT)
BEGIN
IF p_student>0 THEN 
	SELECT 
		`tb_class_student_relation`.`cid` 		AS cid,
		`tb_class_student_relation`.`id`		AS id,
		`tb_class_student_relation`.`creationtime`	AS creationtime,
		`tb_class_student_relation`.`state`		AS state,
		`tb_user`.`userid`				AS `userid`,
		`tb_user`.`name`				AS `name`,
		`tb_user`.`mobilephone`				AS `mobilephone`,
		`tb_class`.`name`				AS `classname`,
		2						AS `type`,
		`tb_class`.`master`				AS `master`
	FROM `tb_class_student_relation`
	LEFT JOIN tb_user
		ON (`tb_class_student_relation`.`student`=`tb_user`.`userid` AND `tb_user`.`state`=1)
	LEFT JOIN `tb_class`
		ON (`tb_class_student_relation`.`cid`=`tb_class`.`cid`)
	WHERE `tb_class_student_relation`.`state`=p_state AND `tb_class_student_relation`.`deleted`=0  AND `tb_user`.`state`=1 AND `tb_user`.`deleted`=0 AND `tb_class_student_relation`.`student`=p_student;
ELSE
	SELECT 
		`tb_class_student_relation`.`cid` 		AS cid,
		`tb_class_student_relation`.`id`		AS id,
		`tb_class_student_relation`.`creationtime`	AS creationtime,
		`tb_class_student_relation`.`state`		AS state,
		`tb_user`.`userid`				AS `userid`,
		`tb_user`.`name`				AS `name`,
		2						AS `type`,
		`tb_user`.`mobilephone`				AS `mobilephone`
	FROM `tb_class_student_relation`
	LEFT JOIN tb_user
		ON (`tb_class_student_relation`.`student`=`tb_user`.`userid` AND `tb_user`.`state`=1)
	WHERE `tb_class_student_relation`.`cid` = p_cid AND `tb_class_student_relation`.`state`=p_state AND `tb_class_student_relation`.`deleted`=0  AND `tb_user`.`state`=1 AND `tb_user`.`deleted`=0;
END IF;
END$$

DELIMITER ;