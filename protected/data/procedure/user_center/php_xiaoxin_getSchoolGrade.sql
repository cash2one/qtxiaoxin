DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_getSchoolGrade`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_getSchoolGrade`(p_sid INT)
BEGIN 
	DECLARE p_stid VARCHAR(50);
	SELECT stid INTO p_stid FROM tb_school WHERE sid=p_sid;
	SELECT * FROM `tb_grade` WHERE deleted=0 AND FIND_IN_SET(stid,p_stid);
END$$

DELIMITER ;