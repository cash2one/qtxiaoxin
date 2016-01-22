DELIMITER $$

USE `user_center`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_GetTableRecordByPk`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_GetTableRecordByPk`(p_tablename VARCHAR(256), p_pk BIGINT)
BEGIN
	DECLARE p_key VARCHAR(32);
	DECLARE p_dbname VARCHAR(32);
	SELECT DATABASE() INTO p_dbname;
	SELECT k.column_name INTO p_key
	FROM information_schema.table_constraints t
	JOIN information_schema.key_column_usage k
	USING (constraint_name,table_schema,table_name)
	WHERE t.constraint_type='PRIMARY KEY'
	AND t.table_schema=p_dbname
	AND t.table_name=p_tablename;
	
	SET @sql = CONCAT('select * from ',p_tablename,' where ',p_key,'=',p_pk);
	
	PREPARE stmt FROM @sql;  
	EXECUTE stmt;  
	DEALLOCATE PREPARE stmt;  
    END$$

DELIMITER ;