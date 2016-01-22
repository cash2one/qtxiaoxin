DELIMITER $$

USE `user_center_new`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_Activestudent`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_Activestudent`(p_cid BIGINT(20),p_name VARCHAR(50),p_password VARCHAR(50),p_mobilephone VARCHAR(20),codeid BIGINT,p_version INT,p_stid VARCHAR(20))
BEGIN
	DECLARE state INT DEFAULT 0;
	DECLARE p_count BIGINT DEFAULT 0;
	DECLARE p_gcount BIGINT DEFAULT 0;
	DECLARE p_extcount BIGINT DEFAULT 0;
	DECLARE p_num INT;
	DECLARE p_role INT;
	DECLARE p_uid INT;
	DECLARE p_hasstudent INT;
	DECLARE p_puid INT;
	DECLARE p_epuid INT;
	DECLARE p_sid BIGINT;
	DECLARE p_maxuid INT;
	DECLARE t_error INTEGER DEFAULT 0;  
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET t_error=1;
	
	START TRANSACTION; 
	SELECT userid INTO p_sid FROM tb_cdkey WHERE id=codeid;
	SELECT userid,identity INTO p_epuid,p_role FROM tb_user WHERE mobilephone=p_mobilephone AND deleted=0;
	SELECT maxID INTO p_num FROM `tb_user_maxid` WHERE `type`=0 AND `version`=p_version;
	
	IF ISNULL(p_sid) THEN
	
		/*学生用户不存在 */
		SELECT (p_num+1)*100+p_version INTO p_uid;
		SELECT (p_num+2)*100+p_version INTO p_puid;
		/*创建学生 */
		INSERT INTO tb_user (`userid`,`account`,`pwd`,`name`,`identity`,`mobilephone`,`state`,`version`) VALUES (p_uid,CONCAT('s',p_uid),p_password,p_name,2,'',1,p_version);
		INSERT INTO tb_student_ext (userid,studentid) VALUES (p_uid,p_stid);
		SELECT p_num+1 INTO p_maxuid;
		UPDATE `tb_user_maxid` SET maxID=p_maxuid  WHERE `type`=0 AND `version`=p_version; 
		IF ISNULL(p_epuid) THEN
			INSERT INTO tb_user (`userid`,`account`,`pwd`,`name`,`identity`,`mobilephone`,`state`,`version`) VALUES (p_puid,CONCAT('p',p_puid),p_password,CONCAT('用户',RIGHT(p_mobilephone,4)),4,p_mobilephone,1,p_version);
			SELECT p_num+2 INTO p_maxuid;
			UPDATE `tb_user_maxid` SET maxID=p_maxuid  WHERE `type`=0 AND `version`=p_version;
			INSERT INTO `tb_class_student_relation` (cid,student,state,creater) VALUES( p_cid,p_uid,1,p_puid);
			UPDATE `tb_class` SET total=total+1 WHERE cid=p_cid;
			
			INSERT INTO `tb_guardian` (child,guardian,main) VALUES (p_uid,p_puid,1);
			UPDATE tb_cdkey SET userid=p_uid WHERE id=codeid;
		ELSE
			SELECT COUNT(*) INTO p_hasstudent FROM tb_guardian INNER JOIN tb_user ON (tb_guardian.child=tb_user.userid) WHERE tb_guardian.guardian=p_epuid AND tb_user.`name`=p_name AND tb_user.deleted=0 AND tb_guardian.deleted=0;
			IF p_hasstudent=0 THEN
				INSERT INTO `tb_class_student_relation` (cid,student,state,creater) VALUES( p_cid,p_uid,1,p_epuid);
				UPDATE `tb_class` SET total=total+1 WHERE cid=p_cid;
				INSERT INTO `tb_guardian` (child,guardian,main) VALUES (p_uid,p_epuid,1);
				UPDATE tb_cdkey SET userid=p_uid WHERE id=codeid;
			END IF;
			IF p_role=4 OR p_role=5 THEN
				UPDATE tb_user SET pwd=p_password WHERE userid=p_epuid;
			ELSE
				UPDATE tb_user SET pwd=p_password,identity=5 WHERE userid=p_epuid;
			END IF;
		END IF;
	ELSE
		/*学生用户已存在 */
		
		IF ISNULL(p_epuid) THEN
			/*家长用户不存在 */
			SELECT (p_num+1)*100+p_version INTO p_puid;
			INSERT INTO tb_user (`userid`,`account`,`pwd`,`name`,`identity`,`mobilephone`,`state`,`version`) VALUES (p_puid,CONCAT('p',p_puid),p_password,CONCAT('用户',RIGHT(p_mobilephone,4)),4,p_mobilephone,1,p_version);
			SELECT p_num+1 INTO p_maxuid;
			UPDATE `tb_user_maxid` SET maxID=p_maxuid  WHERE `type`=0 AND `version`=p_version;
			INSERT INTO `tb_guardian` (child,guardian) VALUES (p_sid,p_puid);
		ELSE
		/*家长用户已存在 */
			SELECT COUNT(*) INTO p_gcount FROM tb_guardian WHERE child=p_sid AND guardian=p_epuid;
			
			IF p_gcount=0 THEN
				INSERT INTO `tb_guardian` (child,guardian) VALUES (p_sid,p_epuid);
			END IF; 
			IF p_role=4 OR p_role=5 THEN
				UPDATE tb_user SET pwd=p_password WHERE userid=p_epuid;
			ELSE
				UPDATE tb_user SET pwd=p_password,identity=5 WHERE userid=p_epuid;
			END IF;
		END IF;
		
		SELECT COUNT(*) INTO p_extcount FROM tb_student_ext WHERE userid=p_sid;
		IF p_extcount>0 THEN 
			UPDATE tb_student_ext SET studentid=p_stid WHERE userid=p_sid;
		ELSE
			INSERT INTO tb_student_ext (userid,studentid) VALUES (p_sid,p_stid);
		END IF;
		
	END IF;
	IF t_error=1 THEN  
		ROLLBACK;  
	ELSE  
		COMMIT;  
	END IF;
	SELECT t_error;
END$$

DELIMITER ;