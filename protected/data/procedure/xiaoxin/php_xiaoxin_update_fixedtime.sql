DELIMITER $$

USE `xiaoxin`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_update_fixedtime`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_update_fixedtime`(_noticeId BIGINT)
BEGIN
/*取消 发送时*/
	UPDATE tb_notice_fixedtime
 SET   deleted=1
  WHERE id=_noticeId ; 

END$$

DELIMITER ;