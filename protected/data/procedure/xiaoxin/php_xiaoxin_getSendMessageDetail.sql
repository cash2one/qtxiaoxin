DELIMITER $$

USE `xiaoxin`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_getSendMessageDetail`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_getSendMessageDetail`(id BIGINT)
BEGIN
	
	SELECT tb_notice.*,(SELECT COUNT(*) AS replyNum FROM tb_notice_reply re WHERE re.noticeid=tb_notice.noticeid AND deleted=0) AS replyNum FROM tb_notice WHERE noticeid=id;
END$$

DELIMITER ;