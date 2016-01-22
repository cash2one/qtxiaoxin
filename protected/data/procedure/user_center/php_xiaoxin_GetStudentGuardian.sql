DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_GetStudentGuardian`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_GetStudentGuardian`(p_student INT,p_deleted INT)
BEGIN
	SELECT 
		`tb_guardian`.`id` 			AS `id`,
		`tb_guardian`.`child`			AS `child`,
		`tb_guardian`.`guardian`		AS `guardian`,
		`tb_guardian`.`role`			AS `role`,
		`tb_guardian`.`state`			AS `state`,
		`tb_guardian`.`main`			AS `main`,
		`tb_guardian`.`creationtime`		AS `creationtime`,
		`tb_guardian`.`updatetime`		AS `updatetime`,
		`tb_user`.`name`			AS `name`,
		`tb_user`.`mobilephone`			AS `mobilephone`
	FROM `tb_guardian` 
	LEFT JOIN `tb_user`
		ON (`tb_user`.`userid`=`tb_guardian`.`guardian` AND `tb_user`.`deleted`=0) 
	WHERE `tb_guardian`.`child`=p_student AND `tb_guardian`.`deleted`=p_deleted AND `tb_user`.`deleted`=0 ORDER BY `tb_guardian`.`main` DESC,`tb_user`.`name`;
END$$

DELIMITER ;