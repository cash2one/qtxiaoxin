DELIMITER $$

USE `xiaoxin`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_getNewsMessage`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_getNewsMessage`(uid BIGINT,n INT,identity INT)
BEGIN
  DECLARE sqltext VARCHAR(1000);
  IF identity=1 THEN
    SET sqltext=CONCAT(" select tb_notice_message.*  from tb_notice_message  where receiver=",uid," and deleted=0 order by sendtime desc limit ",n);
  ELSE 
  	SET sqltext=CONCAT(" select tb_notice_message.*  from tb_notice_message  where FIND_IN_SET('",uid,"',rguardian",") and deleted=0 order by sendtime desc limit ",n);
  END IF;
SET @sqltext:=sqltext;
PREPARE stmt FROM @sqltext;
EXECUTE stmt;
DEALLOCATE PREPARE stmt; 
END$$

DELIMITER ;