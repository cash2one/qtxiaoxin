DELIMITER $$

USE `xiaoxin`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_getMessage_byfamily`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_getMessage_byfamily`(uid BIGINT,noticeType VARCHAR(200),startTime TIMESTAMP,endTime TIMESTAMP,page INT,pagesize INT,keyword VARCHAR(100),returnlist INT)
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
  SET sqltext=CONCAT(" select tb_notice_message.*,(select count(*) as replyNum from tb_notice_reply re where re.noticeid=tb_notice_message.noticeid and deleted=0) as replyNum from tb_notice_message  where FIND_IN_SET('",uid,"',",'rguardian',")");
ELSE 
  SET sqltext=CONCAT(" select count(*) as num from tb_notice_message  where FIND_IN_SET('",uid,"',rguardian",")");
END IF;
IF noticeType!='' THEN
   SET sqltext:=CONCAT(sqltext," and noticetype in( ",noticetype,')');
END IF;
IF LENGTH(keyword)>0 THEN 
   SET sqltext:=CONCAT(sqltext," and content like '%",keyword,"%'");
END IF;
IF returnlist=1 THEN
SET sqltext:=CONCAT(sqltext," and sendtime>='",startTime,"' and sendtime<='",endTime,"' and deleted=0   order by `read`,sendtime desc limit ", startlimit,',',pagesize);
ELSE 
SET sqltext:=CONCAT(sqltext," and sendtime>='",startTime,"' and sendtime<='",endTime,"' and deleted=0 ");
END IF;
SET @sqltext:=sqltext;
PREPARE stmt FROM @sqltext;
EXECUTE stmt;
DEALLOCATE PREPARE stmt; 
END$$

DELIMITER ;