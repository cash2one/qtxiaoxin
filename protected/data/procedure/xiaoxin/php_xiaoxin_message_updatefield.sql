DELIMITER $$

USE `xiaoxin`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_message_updatefield`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_message_updatefield`(uid INT,id INT ,FIELD VARCHAR(50),fieldvalue VARCHAR(255))
BEGIN
  DECLARE sqltext VARCHAR(1000);
	SET sqltext:=CONCAT('update tb_notice_message',' set `',FIELD,'`=',fieldvalue,'  where receiver=',uid,' and msgid=',id);
	
  SET @sqls:=sqltext;
	PREPARE stmt FROM @sqls;
  EXECUTE  stmt; 
 DEALLOCATE PREPARE stmt; 
END$$

DELIMITER ;