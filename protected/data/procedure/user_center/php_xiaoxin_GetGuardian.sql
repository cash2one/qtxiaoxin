DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_GetGuardian`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_GetGuardian`(
	p_child	BIGINT(20),
	p_guardian BIGINT(20)
)
BEGIN
	SELECT * FROM `tb_guardian` WHERE `tb_guardian`.`child`=p_child AND `tb_guardian`.`guardian`=p_guardian AND `tb_guardian`.`deleted`=0 LIMIT 1;
END$$

DELIMITER ;