DELIMITER $$

USE `xiaoxin`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_getMessageDetail`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_getMessageDetail`(noticeId INT)
BEGIN
	SELECT tb_notice_message.*,(SELECT COUNT(*) AS replyNum FROM tb_notice_reply re WHERE re.noticeid=tb_notice_message.noticeid AND deleted=0) AS replyNum FROM tb_notice_message WHERE msgid=noticeid;
END$$

DELIMITER ;