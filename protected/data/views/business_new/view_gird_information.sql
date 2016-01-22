DELIMITER $$

USE `business_new`$$

DROP VIEW IF EXISTS `view_gird_information`$$

CREATE ALGORITHM=UNDEFINED DEFINER=`dbManager`@`%` SQL SECURITY DEFINER VIEW `view_gird_information` AS (
SELECT
  `tb_information`.`iid`          AS `iid`,
  `tb_information`.`title`        AS `title`,
  `tb_information`.`bid`          AS `gbid`,
  `tb_business`.`name`            AS `bname`,
  `tb_information`.`creationtime` AS `gctime`,
  (SELECT
     COUNT(0)                        AS `num`
   FROM `tb_client_log_school_relation`
   WHERE ((`tb_client_log_school_relation`.`tid` = `tb_information`.`iid`)
          AND (`tb_client_log_school_relation`.`target` = 'Information')
          AND (`tb_client_log_school_relation`.`action` = 'Browse'))) AS `viewcount`
FROM (`tb_information`
   LEFT JOIN `tb_business`
     ON ((`tb_business`.`bid` = `tb_information`.`bid`)))
WHERE (`tb_information`.`deleted` = 0)
ORDER BY `gctime` DESC)$$

DELIMITER ;