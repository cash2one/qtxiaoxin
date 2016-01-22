DELIMITER $$

USE `business_new`$$

DROP VIEW IF EXISTS `view_focus_relation_count`$$

CREATE ALGORITHM=UNDEFINED DEFINER=`dbManager`@`%` SQL SECURITY DEFINER VIEW `view_focus_relation_count` AS (
SELECT
  `tb_focus`.`fid`          AS `fid`,
  `tb_focus`.`title`        AS `title`,
  `tb_focus`.`summery`      AS `summery`,
  `tb_focus`.`text`         AS `text`,
  `tb_focus`.`image`        AS `image`,
  `tb_focus`.`url`          AS `url`,
  `tb_focus`.`bid`          AS `bid`,
  `tb_focus`.`uid`          AS `uid`,
  `tb_focus`.`type`         AS `type`,
  `tb_focus`.`state`        AS `state`,
  `tb_focus`.`creationtime` AS `creationtime`,
  `tb_focus`.`updatetime`   AS `updatetime`,
  `tb_focus`.`deleted`      AS `deleted`,
  `tb_focus`.`total`        AS `total`,
  COUNT(`tb_contract_focus_relation`.`cfrid`) AS `connum`
FROM (`tb_focus`
   LEFT JOIN `tb_contract_focus_relation`
     ON (((`tb_focus`.`fid` = `tb_contract_focus_relation`.`fid`)
          AND (`tb_contract_focus_relation`.`deleted` = 0))))
WHERE (`tb_focus`.`deleted` = 0)
GROUP BY `tb_focus`.`fid`)$$

DELIMITER ;