DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_getStudentClass`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_getStudentClass`(p_student INT,p_state INT)
BEGIN 
	SELECT * FROM `tb_class_student_relation` 
	LEFT JOIN `tb_class`
	ON (`tb_class_student_relation`.`cid`=`tb_class`.`cid`)
	WHERE `tb_class_student_relation`.student=p_student AND `tb_class_student_relation`.state=p_state AND `tb_class_student_relation`.deleted=0 AND `tb_class`.deleted=0;
END$$

DELIMITER ;