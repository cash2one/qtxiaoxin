DELIMITER $$

USE `business_new`$$

DROP VIEW IF EXISTS `view_contract_adv_relation_range`$$

CREATE ALGORITHM=UNDEFINED DEFINER=`dbManager`@`%` SQL SECURITY DEFINER VIEW `view_contract_adv_relation_range` AS (
SELECT
  `tb_contract_advertisement_relation`.`carid`  AS `carid`,
  `tb_contract_advertisement_relation`.`aid`    AS `aid`,
  `tb_contract_advertisement_relation`.`cid`    AS `cid`,
  `tb_contract_advertisement_relation`.`alid`   AS `alid`,
  `tb_contract_advertisement_range`.`sid`       AS `sid`,
  `tb_contract_advertisement_range`.`gid`       AS `gid`,
  `tb_contract_advertisement_range`.`startdate` AS `startdate`,
  `tb_contract_advertisement_range`.`enddate`   AS `enddate`
FROM (`tb_contract_advertisement_relation`
   JOIN `tb_contract_advertisement_range`)
WHERE ((`tb_contract_advertisement_range`.`carid` = `tb_contract_advertisement_relation`.`carid`)
       AND (`tb_contract_advertisement_range`.`deleted` = 0)
       AND (`tb_contract_advertisement_relation`.`deleted` = 0)))$$

DELIMITER ;