DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_getClassStudent`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_getClassStudent`(p_cid INT)
BEGIN 
SELECT 
	`tb_class_student_relation`.`cid` 		AS cid,
	`tb_class_student_relation`.`id`		AS id,
	`tb_class_student_relation`.`creationtime`	AS creationtime,
	`tb_class_student_relation`.`state`		AS state,
	`tb_user`.`userid`				AS `userid`,
	`tb_user`.`name`				AS `name`,
	`tb_user`.`mobilephone`				AS `mobilephone`
FROM `tb_class_student_relation`
LEFT JOIN tb_user
	ON (`tb_class_student_relation`.`student`=`tb_user`.`userid` AND `tb_user`.`state`=1)
WHERE `tb_class_student_relation`.`cid` = p_cid AND `tb_class_student_relation`.`state`=1 AND `tb_class_student_relation`.`deleted`=0  AND `tb_user`.`state`=1;
END$$

DELIMITER ;