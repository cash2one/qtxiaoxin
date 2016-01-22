DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_insert_cdkey`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_insert_cdkey`(p_code VARCHAR(20),p_password VARCHAR(20),p_type INT,p_cid BIGINT)
BEGIN
    INSERT INTO tb_cdkey(cdkey,`password`,TYPE,cid)VALUES(p_code,p_password,p_type,p_cid);
    SELECT LAST_INSERT_ID();
END$$

DELIMITER ;