DELIMITER $$

USE `business_new`$$

DROP VIEW IF EXISTS `view_gird_mall_goods`$$

CREATE ALGORITHM=UNDEFINED DEFINER=`dbManager`@`%` SQL SECURITY DEFINER VIEW `view_gird_mall_goods` AS (
SELECT
  `tb_mall_goods`.`mgid`         AS `mgid`,
  `tb_mall_goods`.`type`         AS `type`,
  `tb_mall_goods`.`name`         AS `name`,
  `tb_mall_goods`.`bid`          AS `gbid`,
  `tb_business`.`name`           AS `bname`,
  `tb_mall_goods`.`creationtime` AS `gctime`,
  (SELECT
     COUNT(0)                       AS `num`
   FROM `tb_client_log_school_relation`
   WHERE ((`tb_client_log_school_relation`.`tid` = `tb_mall_goods`.`mgid`)
          AND (`tb_client_log_school_relation`.`target` = 'Mall')
          AND (`tb_client_log_school_relation`.`action` = 'Browse'))) AS `viewcount`,
  (SELECT
     COUNT(0)                       AS `num`
   FROM `tb_client_log_school_relation`
   WHERE ((`tb_client_log_school_relation`.`tid` = `tb_mall_goods`.`mgid`)
          AND (`tb_client_log_school_relation`.`target` = 'Mall')
          AND (`tb_client_log_school_relation`.`action` = 'Comment'))) AS `commentcount`,
  (SELECT
     COUNT(0)                       AS `num`
   FROM `tb_client_log_school_relation`
   WHERE ((`tb_client_log_school_relation`.`tid` = `tb_mall_goods`.`mgid`)
          AND (`tb_client_log_school_relation`.`target` = 'Mall')
          AND (`tb_client_log_school_relation`.`action` = 'Buy'))) AS `buycount`
FROM (`tb_mall_goods`
   LEFT JOIN `tb_business`
     ON ((`tb_business`.`bid` = `tb_mall_goods`.`bid`)))
WHERE (`tb_mall_goods`.`deleted` = 0)
ORDER BY `gctime` DESC)$$

DELIMITER ;