DELIMITER $$

USE `xiaoxin`$$

DROP PROCEDURE IF EXISTS `php_xiaoxin_get_table_num`$$

CREATE DEFINER=`dbManager`@`%` PROCEDURE `php_xiaoxin_get_table_num`(tablename VARCHAR(100),wheresql VARCHAR(2000))
BEGIN
  DECLARE sqltext VARCHAR(1000);
	SET sqltext:=CONCAT('select count(*) as num from ',tablename,'  where 1=1  ',wheresql);	


  SET @sqls:=sqltext;
	PREPARE stmt FROM @sqls;
  EXECUTE  stmt; 
  DEALLOCATE PREPARE stmt; 

END$$

DELIMITER ;