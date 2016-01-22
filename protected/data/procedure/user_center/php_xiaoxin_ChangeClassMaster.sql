DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_ChangeClassMaster`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_ChangeClassMaster`(p_cid INT, p_master BIGINT)
BEGIN 
	DECLARE p_count INT;
	DECLARE p_rid BIGINT;
	DECLARE t_error INTEGER DEFAULT 0;  
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET t_error=1;
	
	START TRANSACTION; 
		SELECT COUNT(*),`id`  INTO p_count,p_rid  FROM tb_class_teacher_relation WHERE cid=p_cid AND `type`=1 AND deleted=0 LIMIT 1; 
		SELECT p_count;
		UPDATE `tb_class` SET `master`=p_master WHERE cid=p_cid;
		IF p_count<=0 THEN
			INSERT INTO tb_class_teacher_relation(cid,teacher,state,`subject`,`type`) VALUES (p_cid,p_master,1,'',1);
		ELSE
			UPDATE tb_class_teacher_relation SET teacher=p_master, state=1,`type`=1 WHERE id=p_rid;
		END IF;
	IF t_error = 1 THEN  
		ROLLBACK;  
        ELSE  
		COMMIT;  
        END IF;
        SELECT t_error;  
END$$

DELIMITER ;