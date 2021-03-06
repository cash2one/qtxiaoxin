DELIMITER $$

USE `business_new`$$

DROP VIEW IF EXISTS `view_business_con_adv_relation`$$

CREATE ALGORITHM=UNDEFINED DEFINER=`dbManager`@`%` SQL SECURITY DEFINER VIEW `view_business_con_adv_relation` AS (
SELECT
  `tb_business`.`bid`                              AS `bid`,
  `tb_contract`.`cid`                              AS `cid`,
  `tb_contract_advertisement_relation`.`startdate` AS `startdate`,
  `tb_contract_advertisement_relation`.`enddate`   AS `enddate`
FROM ((`tb_business`
    JOIN `tb_contract`)
   JOIN `tb_contract_advertisement_relation`)
WHERE ((`tb_business`.`bid` = `tb_contract`.`bid`)
       AND (`tb_contract`.`cid` = `tb_contract_advertisement_relation`.`cid`)
       AND (`tb_business`.`deleted` = 0)
       AND (`tb_contract`.`deleted` = 0)
       AND (`tb_contract_advertisement_relation`.`deleted` = 0)))$$

DELIMITER ;