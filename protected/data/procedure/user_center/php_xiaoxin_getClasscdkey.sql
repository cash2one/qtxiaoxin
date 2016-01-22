DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_getClasscdkey`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_getClasscdkey`(p_cid INT)
BEGIN 
	SELECT * FROM `tb_cdkey` WHERE cid=p_cid AND deleted=0 ORDER BY userid DESC, updatetime;
END$$

DELIMITER ;