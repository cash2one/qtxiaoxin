DELIMITER $$

USE `business_new`$$

DROP VIEW IF EXISTS `view_gird_focus`$$

CREATE ALGORITHM=UNDEFINED DEFINER=`dbManager`@`%` SQL SECURITY DEFINER VIEW `view_gird_focus` AS (
SELECT
  `tb_focus`.`fid`          AS `fid`,
  `tb_focus`.`title`        AS `title`,
  `tb_focus`.`bid`          AS `gbid`,
  `tb_focus`.`type`         AS `type`,
  `tb_business`.`name`      AS `bname`,
  `tb_focus`.`creationtime` AS `gctime`,
  (SELECT
     COUNT(0)                  AS `num`
   FROM `tb_client_log_school_relation`
   WHERE ((`tb_client_log_school_relation`.`tid` = `tb_focus`.`fid`)
          AND (`tb_client_log_school_relation`.`target` = 'Focus')
          AND (`tb_client_log_school_relation`.`action` = 'Browse'))) AS `viewcount`,
  (SELECT
     COUNT(0)                  AS `num`
   FROM `tb_client_log_school_relation`
   WHERE ((`tb_client_log_school_relation`.`tid` = `tb_focus`.`fid`)
          AND (`tb_client_log_school_relation`.`target` = 'Focus')
          AND (`tb_client_log_school_relation`.`action` = 'Join'))) AS `joincount`
FROM (`tb_focus`
   LEFT JOIN `tb_business`
     ON ((`tb_business`.`bid` = `tb_focus`.`bid`)))
WHERE (`tb_focus`.`deleted` = 0)
ORDER BY `gctime` DESC)$$

DELIMITER ;