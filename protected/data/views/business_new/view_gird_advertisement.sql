DELIMITER $$

USE `business_new`$$

DROP VIEW IF EXISTS `view_gird_advertisement`$$

CREATE ALGORITHM=UNDEFINED DEFINER=`dbManager`@`%` SQL SECURITY DEFINER VIEW `view_gird_advertisement` AS (
SELECT
  `tb_advertisement`.`aid`          AS `aid`,
  `tb_advertisement`.`title`        AS `title`,
  `tb_advertisement`.`bid`          AS `gbid`,
  `tb_business`.`name`              AS `bname`,
  `tb_advertisement`.`creationtime` AS `gctime`,
  (SELECT
     COUNT(0)                          AS `num`
   FROM `tb_client_log_school_relation`
   WHERE ((`tb_client_log_school_relation`.`tid` = `tb_advertisement`.`aid`)
          AND (`tb_client_log_school_relation`.`target` = 'Advertisement')
          AND (`tb_client_log_school_relation`.`action` = 'Browse'))) AS `viewcount`
FROM (`tb_advertisement`
   LEFT JOIN `tb_business`
     ON ((`tb_business`.`bid` = `tb_advertisement`.`bid`)))
WHERE (`tb_advertisement`.`deleted` = 0)
ORDER BY `gctime` DESC)$$

DELIMITER ;