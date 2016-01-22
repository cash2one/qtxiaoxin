DELIMITER $$

USE `xiaoxin`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_insert_message`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_insert_message`(sender INT,receiver TEXT,noticetype INT,content TEXT,sendertitle VARCHAR(100),receivertitle VARCHAR(100),issendsms TINYINT,sid INT,schoolname VARCHAR(100),receiveName1 VARCHAR(1000),_sendtime TIMESTAMP)
BEGIN
INSERT INTO tb_notice(sender,receiver,noticetype,content,sendertitle,receivertitle,issendsms,sid,schoolname,receiveName,sendtime)
VALUES(sender,receiver,noticetype,content,sendertitle,receivertitle,issendsms,sid,schoolname,receiveName1,_sendtime);

END$$

DELIMITER ;