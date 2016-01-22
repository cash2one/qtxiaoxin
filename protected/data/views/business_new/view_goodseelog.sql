DELIMITER $$

USE `business_new`$$

DROP VIEW IF EXISTS `view_goodseelog`$$

CREATE ALGORITHM=UNDEFINED DEFINER=`dbManager`@`%` SQL SECURITY DEFINER VIEW `view_goodseelog` AS (
SELECT
  `g`.`name` AS `name`,
  COUNT(0)   AS `COUNT(*)`
FROM (`tb_actionlog` `l`
   JOIN `tb_mall_goods` `g`
     ON ((`l`.`mgid` = `g`.`mgid`)))
GROUP BY `g`.`name`)$$

DELIMITER ;