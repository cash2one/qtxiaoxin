DELIMITER $$

USE `xiaoxin`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_add_myapplication`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_add_myapplication`(aid INT,uid BIGINT,state INT)
BEGIN
  DECLARE userid1 BIGINT DEFAULT 0;
	DECLARE app1 INT DEFAULT 0;
	DECLARE deleted1 INT DEFAULT 0;
	
  SELECT userid INTO userid1  FROM tb_application_config WHERE  userid=uid AND app=aid;	
	IF state=1 THEN
		IF userid1<1  THEN
			 
			 INSERT INTO tb_application_config(userid,app)VALUES(uid,aid);
		ELSE
			 UPDATE tb_application_config SET deleted=0 WHERE userid=uid AND app=aid;
		END IF;
	ELSE
			UPDATE tb_application_config SET deleted=1 WHERE userid=uid AND app=aid;
  END IF;
     
     
END$$

DELIMITER ;