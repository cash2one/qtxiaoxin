DELIMITER $$

USE `xiaoxin`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_getUnSendMessageDetail`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_getUnSendMessageDetail`(noticeId BIGINT)
BEGIN
	SELECT * FROM tb_notice_fixedtime WHERE id=noticeid;
END$$

DELIMITER ;