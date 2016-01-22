DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_getUserPhoto`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_getUserPhoto`(ids VARCHAR(500))
BEGIN
  DECLARE sqltext VARCHAR(1000);
	SET sqltext:=CONCAT("select t.name,t.userid,te.photo from tb_user t left join tb_user_ext te  on t.userid=te.userid where t.userid in(",ids,") and t.deleted=0");
	SET @sqltext:=sqltext;
	PREPARE stmt FROM @sqltext;
  EXECUTE stmt;
  DEALLOCATE PREPARE stmt;
END$$

DELIMITER ;