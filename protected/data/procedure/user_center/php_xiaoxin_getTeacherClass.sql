DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_getTeacherClass`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_getTeacherClass`(p_uid INT,p_type INT)
BEGIN 
 SELECT 
	`tb_class_teacher_relation`.`cid` 		AS `cid` ,
	`tb_class`.`name`				AS `name`,
	`tb_class`.`total`				AS total,
	`tb_class`.`type`				AS `type`,
	`tb_class`.`master`				AS `master`,
	`tb_class`.`sid`				AS `sid`,
	`tb_school`.`name`				AS `sname`
FROM `tb_class_teacher_relation` 
LEFT JOIN `tb_class`
	ON (`tb_class_teacher_relation`.`cid`=`tb_class`.`cid` AND `tb_class`.`deleted`=0 AND `tb_class`.`type`=p_type)
LEFT JOIN `tb_school`
	ON (`tb_class`.`sid`=`tb_school`.`sid`)
WHERE  `tb_class_teacher_relation`.`teacher`=p_uid AND `tb_class_teacher_relation`.`state`=1 AND `tb_class_teacher_relation`.`deleted`=0 AND `tb_class`.`type`=p_type
GROUP BY `tb_class_teacher_relation`.`cid`;
END$$

DELIMITER ;