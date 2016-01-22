DELIMITER $$

USE `xiaoxin`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_update_readstate`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_update_readstate`(ids VARCHAR(2000))
BEGIN
  DECLARE sqltext VARCHAR(1000);
	SET sqltext:=CONCAT('update tb_notice_message set `read`=1  where msgid in(',ids,')');	
  SET @sqls:=sqltext;
  
	PREPARE stmt FROM @sqls;
  EXECUTE  stmt; 
  DEALLOCATE PREPARE stmt; 
END$$

DELIMITER ;