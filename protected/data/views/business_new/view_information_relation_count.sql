DELIMITER $$

USE `business_new`$$

DROP VIEW IF EXISTS `view_information_relation_count`$$

CREATE ALGORITHM=UNDEFINED DEFINER=`dbManager`@`%` SQL SECURITY DEFINER VIEW `view_information_relation_count` AS (
SELECT
  `tb_information`.`iid`          AS `iid`,
  `tb_information`.`title`        AS `title`,
  `tb_information`.`summery`      AS `summery`,
  `tb_information`.`text`         AS `text`,
  `tb_information`.`image`        AS `image`,
  `tb_information`.`bigimage`     AS `bigimage`,
  `tb_information`.`source`       AS `source`,
  `tb_information`.`url`          AS `url`,
  `tb_information`.`ikid`         AS `ikid`,
  `tb_information`.`bid`          AS `bid`,
  `tb_information`.`uid`          AS `uid`,
  `tb_information`.`head`         AS `head`,
  `tb_information`.`headtop`      AS `headtop`,
  `tb_information`.`kindtop`      AS `kindtop`,
  `tb_information`.`state`        AS `state`,
  `tb_information`.`creationtime` AS `creationtime`,
  `tb_information`.`updatetime`   AS `updatetime`,
  `tb_information`.`deleted`      AS `deleted`,
  COUNT(`tb_contract_infomation_relation`.`cirid`) AS `connum`
FROM (`tb_information`
   LEFT JOIN `tb_contract_infomation_relation`
     ON (((`tb_information`.`iid` = `tb_contract_infomation_relation`.`iid`)
          AND (`tb_contract_infomation_relation`.`deleted` = 0))))
WHERE (`tb_information`.`deleted` = 0)
GROUP BY `tb_information`.`iid`)$$

DELIMITER ;