DELIMITER $$

USE `xiaoxin`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_getNewsReply`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_getNewsReply`(TYPE INT ,p_uid BIGINT,num INT)
BEGIN
IF TYPE=3 THEN 
 SELECT DISTINCT t.*,f.noticeType,f.msgid FROM tb_notice_reply t INNER JOIN (SELECT noticeid ,noticetype,msgid FROM tb_notice_message WHERE FIND_IN_SET(p_uid,rguardian) AND deleted=0) f 
   ON t.noticeid=f.noticeid WHERE t.deleted=0 ORDER BY creationtime DESC LIMIT 4 ;
ELSE 
  SELECT  t.*,f.noticeType  FROM tb_notice_reply t INNER JOIN  (SELECT noticeid,noticetype  FROM tb_notice WHERE sender=p_uid) f
  ON t.noticeid=f.noticeid WHERE t.deleted=0 ORDER BY t.creationtime DESC LIMIT 4 ;
/*select t.*,f.noticeType from tb_notice_reply t inner join tb_notice f on t.noticeId=f.noticeId where  t.deleted=0 and f.deleted=0    order by creationtime desc limit num;*/
END IF;
END$$

DELIMITER ;