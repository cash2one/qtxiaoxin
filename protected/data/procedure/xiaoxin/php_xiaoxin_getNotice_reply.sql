DELIMITER $$

USE `xiaoxin`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_getNotice_reply`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_getNotice_reply`(id BIGINT,page INT,pagesize INT)
BEGIN
DECLARE startlimit INT DEFAULT 0;
DECLARE startpage INT DEFAULT 1;
IF page<0 THEN
   SET startpage:=1;
ELSE 
   SET startpage:=page;
END IF;
IF pagesize<0 THEN 
   SET pagesize:=15;
END IF;
SET startlimit:=(page-1)*pagesize;
IF startlimit<0 THEN
   SET startlimit:=0;
END IF;


SELECT * FROM tb_notice_reply  WHERE noticeId=id  AND deleted=0  ORDER BY creationtime DESC LIMIT startlimit,pagesize;

END$$

DELIMITER ;