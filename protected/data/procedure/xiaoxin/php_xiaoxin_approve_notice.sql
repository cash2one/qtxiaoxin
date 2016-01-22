DELIMITER $$

USE `xiaoxin`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_approve_notice`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_approve_notice`(uid BIGINT,approvestatus INT,reason VARCHAR(1000),noticeIds VARCHAR(2000))
BEGIN
	DECLARE sqltext VARCHAR(2000);	
	DECLARE done INT DEFAULT 0;
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET done=1;
	SET sqltext=CONCAT("update tb_notice_fixedtime set approveid=",uid,",`status`=",approvestatus,",approvetime=now(),sendtime=if(sendtime>now(),sendtime,now()),
	     reason='",reason ,"' where id in(",noticeIds,")");
  SELECT sqltext;
  SET @sqltext:=sqltext;
	PREPARE stmt FROM @sqltext;
	EXECUTE stmt;
	DEALLOCATE PREPARE stmt;
 
  
END$$

DELIMITER ;