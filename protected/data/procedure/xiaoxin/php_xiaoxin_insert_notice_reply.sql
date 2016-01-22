DELIMITER $$

USE `xiaoxin`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_insert_notice_reply`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_insert_notice_reply`(uid INT,noticeId INT,receiver INT,content TEXT,nameless INT)
BEGIN
   INSERT INTO tb_notice_reply(noticeId,sender,receiver,content,nameless) VALUES(noticeId,uid,receiver,content,nameless);
END$$

DELIMITER ;