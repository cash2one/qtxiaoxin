DELIMITER $$

USE `user_center_new`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_Activeteacher`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_Activeteacher`(p_cid BIGINT(20),p_name VARCHAR(50),p_password VARCHAR(50),p_mobilephone VARCHAR(20),codeid BIGINT,p_version INT)
BEGIN
	DECLARE state INT DEFAULT 0;
	DECLARE p_count BIGINT DEFAULT 0;
	DECLARE p_tcid BIGINT DEFAULT 0;
	DECLARE p_tsid BIGINT DEFAULT 0;
	DECLARE p_ts BIGINT DEFAULT 0;
	DECLARE p_num INT;
	DECLARE p_role INT;
	DECLARE p_tuid INT;
	DECLARE p_uid INT;
	DECLARE p_sid BIGINT;
	DECLARE p_maxuid INT;
	DECLARE t_error INTEGER DEFAULT 0;  
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET t_error=1;
	
	START TRANSACTION; 
	SELECT COUNT(*), userid,identity INTO p_count,p_tuid,p_role FROM tb_user  WHERE mobilephone=p_mobilephone AND deleted=0 LIMIT 1;
	
	IF p_count>0 THEN
		/*老师用户已存在 */
		IF p_role=1 OR p_role=5 THEN 
			UPDATE tb_user SET pwd=p_password WHERE userid=p_tuid;
		ELSE
			UPDATE tb_user SET pwd=p_password,identity=5 WHERE userid=p_tuid;
		END IF;
		
		SELECT COUNT(*) INTO p_tcid FROM tb_class_teacher_relation WHERE teacher=p_tuid AND cid=p_cid AND deleted=0;
		IF p_tcid=0 THEN 
			/*新建老师班级关系*/
			INSERT INTO tb_class_teacher_relation (teacher,cid,state) VALUES (p_tuid,p_cid,1);
			SELECT sid INTO p_ts FROM tb_class WHERE cid=p_cid;
			SELECT COUNT(*) INTO p_tsid FROM tb_school_teacher_relation WHERE teacher=p_tuid AND sid=p_ts AND deleted=0;
			IF p_tsid=0 THEN
				/*新建老师学校关系*/
				INSERT INTO tb_school_teacher_relation (teacher,sid,state) VALUES (p_tuid,p_ts,'1');
			END IF;
		END IF;
		/* 更新tb_cdkey */
		UPDATE tb_cdkey SET userid=p_tuid WHERE id=codeid;
	ELSE 
		
		/*创建用户 */
		SELECT maxID INTO p_num FROM `tb_user_maxid` WHERE `type`=0 AND `version`=p_version;
		
		
		SELECT (p_num+1)*100+p_version INTO p_uid;
	
		INSERT INTO tb_user (`userid`,`account`,`pwd`,`name`,`identity`,`mobilephone`,`state`,`version`) VALUES (p_uid,CONCAT('p',p_uid),p_password,p_name,1,p_mobilephone,1,p_version);
		SELECT p_num+1 INTO p_maxuid;
		UPDATE `tb_user_maxid` SET maxID=p_maxuid  WHERE `type`=0 AND `version`=p_version;
		
		/*老师班级关系 */
		INSERT INTO `tb_class_teacher_relation` (cid,teacher,state,creater,`subject`) VALUES( p_cid,p_uid,1,p_uid,''); 
	
		/*更新班级老师人数 */
		UPDATE `tb_class` SET teachers=teachers+1 WHERE cid=p_cid;
		
		/*老师学校关系 */
		SELECT sid INTO p_sid FROM tb_class WHERE cid=p_cid;
		
		INSERT INTO tb_school_teacher_relation (sid,teacher) VALUES (p_sid,p_uid);
		/* 更新tb_cdkey */
		UPDATE tb_cdkey SET userid=p_uid WHERE id=codeid;
		
    END IF;
   IF t_error = 1 THEN  
			ROLLBACK;  
		ELSE  
			COMMIT;  
		END IF;
   SELECT t_error;
END$$

DELIMITER ;