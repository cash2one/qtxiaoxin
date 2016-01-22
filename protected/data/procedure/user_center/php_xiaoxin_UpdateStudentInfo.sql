DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_UpdateStudentInfo`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_UpdateStudentInfo`(
	p_userid	BIGINT(20),
	p_name 		VARCHAR(20),
	p_sex		TINYINT,
	p_photo 	VARCHAR(256),
	p_birthday	DATE,
	p_gid		BIGINT(20),
	p_role		VARCHAR(10)
)
BEGIN
	DECLARE p_count INT;
	DECLARE t_error INTEGER DEFAULT 0;  
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET t_error=1;  
	START TRANSACTION; 
		UPDATE tb_user SET `name`=p_name, `sex`=p_sex WHERE `userid`= p_userid;
		SELECT COUNT(*) INTO p_count FROM tb_user_ext WHERE userid=p_userid;
		IF p_count<=0 THEN 
			INSERT INTO `tb_user_ext` (userid,photo,birthday) VALUES (p_userid,p_photo,p_birthday);
		ELSE 
			UPDATE `tb_user_ext` SET photo=p_photo,birthday=p_birthday WHERE userid=p_userid;
		END IF;
		UPDATE `tb_guardian` SET role=p_role WHERE id=p_gid;
	IF t_error = 1 THEN  
		ROLLBACK;  
        ELSE  
		COMMIT;  
        END IF;
        SELECT t_error; 
    END$$

DELIMITER ;