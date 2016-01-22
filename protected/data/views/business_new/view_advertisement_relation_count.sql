DELIMITER $$

USE `business_new`$$

DROP VIEW IF EXISTS `view_advertisement_relation_count`$$

CREATE ALGORITHM=UNDEFINED DEFINER=`dbManager`@`%` SQL SECURITY DEFINER VIEW `view_advertisement_relation_count` AS (
SELECT
  `tb_advertisement`.`aid`          AS `aid`,
  `tb_advertisement`.`title`        AS `title`,
  `tb_advertisement`.`summery`      AS `summery`,
  `tb_advertisement`.`text`         AS `text`,
  `tb_advertisement`.`image`        AS `image`,
  `tb_advertisement`.`url`          AS `url`,
  `tb_advertisement`.`bid`          AS `bid`,
  `tb_advertisement`.`uid`          AS `uid`,
  `tb_advertisement`.`state`        AS `state`,
  `tb_advertisement`.`creationtime` AS `creationtime`,
  `tb_advertisement`.`updatetime`   AS `updatetime`,
  `tb_advertisement`.`deleted`      AS `deleted`,
  COUNT(`tb_contract_advertisement_relation`.`carid`) AS `connum`
FROM (`tb_advertisement`
   LEFT JOIN `tb_contract_advertisement_relation`
     ON (((`tb_advertisement`.`aid` = `tb_contract_advertisement_relation`.`aid`)
          AND (`tb_contract_advertisement_relation`.`deleted` = 0))))
WHERE (`tb_advertisement`.`deleted` = 0)
GROUP BY `tb_advertisement`.`aid`)$$

DELIMITER ;