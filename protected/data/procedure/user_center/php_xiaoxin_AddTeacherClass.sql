DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_AddTeacherClass`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_AddTeacherClass`(
		p_name VARCHAR(50), 
		p_year INT, 
		p_sid INT,
		p_stid INT,
		p_type INT,
		p_master INT,
		p_info VARCHAR(1024),
		p_version INT
	)
BEGIN 
	DECLARE p_cid INT;  
	DECLARE p_pk INT;
	DECLARE p_maxuid INT;
	DECLARE p_ctrid INT DEFAULT 0;  
	DECLARE t_error INTEGER DEFAULT 0;  
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET t_error=1;
	
	START TRANSACTION; 
		SELECT maxID INTO p_pk FROM `tb_user_maxid` WHERE `type`=1 AND `version`=p_version;
		SELECT (p_pk+1)*100+p_version INTO p_cid;
		INSERT INTO `tb_class` (cid,`name`, `year`, `sid`, `stid`, `type`, `master`, `info`) VALUES(p_cid,p_name,p_year,p_sid,p_stid,p_type,p_master,p_info);
		SELECT p_pk+1 INTO p_maxuid;
		UPDATE `tb_user_maxid` SET maxID=p_maxuid  WHERE `type`=1 AND `version`=p_version; 
		INSERT INTO `tb_class_teacher_relation`(cid,teacher,state,`subject`,`type`)VALUES(p_cid,p_master,1,'',1);
		UPDATE `tb_class` SET teachers=teachers+1 WHERE cid=p_cid;
	IF t_error = 1 THEN  
		ROLLBACK;  
        ELSE  
		COMMIT;  
        END IF;
        SELECT p_cid;  
END$$

DELIMITER ;