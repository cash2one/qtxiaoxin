DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_getParentStudent`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_getParentStudent`(p_pid BIGINT)
BEGIN 
SELECT 
	`tb_guardian`.`child` 			AS `child`,
	`tb_guardian`.`guardian`		AS `guardian`,
	`tb_guardian`.`id`			AS `id`,
	`tb_guardian`.`main`			AS `main`,
	`tb_guardian`.`role`			AS `role`,
	`tb_user`.`name`			AS `name`,
	`tb_user`.`sex`				AS `sex`,
	`tb_user_ext`.birthday			AS `birthday`	
FROM `tb_guardian`
LEFT JOIN `tb_user`
	ON (`tb_guardian`.`child`=`tb_user`.`userid` AND `tb_user`.`identity`=2)
LEFT JOIN `tb_user_ext`
	ON (`tb_guardian`.`child`=`tb_user_ext`.`userid`)
WHERE `tb_guardian`.`deleted`=0 AND `tb_guardian`.`guardian`=p_pid AND `tb_user`.`identity`=2 AND `tb_user`.`deleted`=0;
END$$

DELIMITER ;