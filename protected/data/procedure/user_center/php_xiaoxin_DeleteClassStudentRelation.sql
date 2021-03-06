DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_DeleteClassStudentRelation`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_DeleteClassStudentRelation`(p_id INT)
BEGIN
	DECLARE p_cid INT;
	DECLARE t_error INTEGER DEFAULT 0;  
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET t_error=1;  
	START TRANSACTION; 
		SELECT `tb_class_student_relation`.`cid` INTO p_cid FROM `tb_class_student_relation` WHERE id= p_id;
		UPDATE `tb_class_student_relation` SET `deleted`=1 WHERE id= p_id;
		UPDATE `tb_class` SET total=total-1 WHERE cid=p_cid;
	IF t_error = 1 THEN  
		ROLLBACK;  
        ELSE  
		COMMIT;  
        END IF;
        SELECT t_error; 
    END$$

DELIMITER ;