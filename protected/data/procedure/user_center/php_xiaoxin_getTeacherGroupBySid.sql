DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_getTeacherGroupBySid`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_getTeacherGroupBySid`(p_creater BIGINT,p_type INT,sid INT)
BEGIN
	
	SET   @SQL   ='SELECT 
				`tb_group`.`gid`		AS `gid`,
				`tb_group`.`name`		AS `name`,
				`tb_group`.`state`		AS `state`,
				`tb_group`.`type`		AS `type`,
				`tb_group`.`creater`		AS `creater`,
				`tb_group`.`creationtime`	AS `creationtime`,
				COUNT(`tb_group_member`.`gid`)	AS `member`
			FROM `tb_group` LEFT JOIN `tb_group_member`
				ON (`tb_group`.`gid`=`tb_group_member`.`gid` AND `tb_group_member`.`deleted`=0)';
	SET @where = CONCAT('WHERE `tb_group`.`deleted`=0 AND tb_group.sid=',sid,' AND `tb_group`.`creater`=',p_creater); 	 
	IF (p_type!=-1) THEN 
		SET @where=CONCAT(@where, '  AND `tb_group`.`type`= ',p_type); 
	END  IF;
	
	SET @SQL=CONCAT(@SQL, @where, ' GROUP BY `tb_group`.`gid`'); 
	PREPARE   stmt   FROM   @sql; 
	EXECUTE   stmt   ; 
	DEALLOCATE   PREPARE   stmt; 
    END$$

DELIMITER ;