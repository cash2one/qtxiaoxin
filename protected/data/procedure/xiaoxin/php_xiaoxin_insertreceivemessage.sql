DELIMITER $$

USE `xiaoxin`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_insertreceivemessage`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_insertreceivemessage`(p_noticeId BIGINT,p_sender BIGINT,receiver BIGINT,noticetype INT,content TEXT,
sendertitle VARCHAR(100),receivertitle VARCHAR(100),sid INT,schoolname VARCHAR(100),p_uname VARCHAR(50),rguardian VARCHAR(100),p_sendtime TIMESTAMP)
BEGIN
INSERT INTO tb_notice_message(noticeId,sender,receiver,noticetype,content,sendertitle,receivertitle,sid,schoolname,uname,rguardian,sendtime)
VALUES(p_noticeId,p_sender,receiver,noticetype,content,sendertitle,receivertitle,sid,schoolname,p_uname,rguardian,p_sendtime);
END$$

DELIMITER ;