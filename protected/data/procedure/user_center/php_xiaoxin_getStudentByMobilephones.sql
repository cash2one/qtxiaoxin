DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_getStudentByMobilephones`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_getStudentByMobilephones`(p_mobilephones TEXT)
BEGIN 
	SELECT mobilephone AS student FROM `tb_user` 
	WHERE FIND_IN_SET(mobilephone,p_mobilephones) AND `tb_user`.`deleted`=0 AND `tb_user`.`state`=1 AND `tb_user`.`identity`=2;
END$$

DELIMITER ;