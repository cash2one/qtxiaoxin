DELIMITER $$

USE `xiaoxin`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_approve_list`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_approve_list`(p_sid VARCHAR(200),noticeType VARCHAR(2000),startTime TIMESTAMP,endTime TIMESTAMP,page INT,pagesize INT,keyword VARCHAR(100),returnlist INT,p_status VARCHAR(20),p_uid BIGINT)
BEGIN
DECLARE startlimit INT DEFAULT 0;
DECLARE startpage INT DEFAULT 1;
DECLARE sqltext VARCHAR(2000);
IF page<0 THEN
   SET startpage:=1;
ELSE 
   SET startpage:=page;
END IF;
SET startlimit:=(page-1)*pagesize;
IF startlimit<0 THEN
   SET startlimit:=0;
END IF;
IF returnlist=1 THEN
	SET sqltext=CONCAT(" select tb_notice_fixedtime.* from tb_notice_fixedtime  where sid in(",p_sid,")");
ELSE 
  SET sqltext=CONCAT(" select count(*) as num from tb_notice_fixedtime  where sid in(",p_sid,")");
END IF;
IF noticeType!='' THEN
   SET sqltext:=CONCAT(sqltext," and noticetype in( ",noticetype,')');
END IF;

IF LENGTH(keyword)>0 THEN 
   SET sqltext:=CONCAT(sqltext," and content like '%",keyword,"%'");
END IF;

SET sqltext:=CONCAT(sqltext," and `status` in(",p_status,")"); 
 
IF returnlist=1 THEN     
			SET sqltext:=CONCAT(sqltext," and creationtime>='",startTime,"' and creationtime<='",endTime,"' and deleted=0  and approvetime is not null order by creationtime desc limit ", startlimit,',',pagesize);	
ELSE
	SET sqltext:=CONCAT(sqltext,"  and creationtime>='",startTime,"' and creationtime<='",endTime,"' and deleted=0 and approvetime is not null  ");	
END IF;


SET @sqltext:=sqltext;
PREPARE stmt FROM @sqltext;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

END$$

DELIMITER ;