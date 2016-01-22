DELIMITER $$

USE `business_new`$$

DROP VIEW IF EXISTS `view_api_infomration_relation`$$

CREATE ALGORITHM=UNDEFINED DEFINER=`dbManager`@`%` SQL SECURITY DEFINER VIEW `view_api_infomration_relation` AS (
SELECT
  `tb_contract_infomation_relation`.`cirid`     AS `cirid`,
  `tb_contract_infomation_relation`.`cid`       AS `cid`,
  `tb_contract_infomation_relation`.`iid`       AS `iid`,
  `tb_contract_infomation_relation`.`startdate` AS `startdate`,
  `tb_information`.`image`                      AS `image`,
  `tb_information`.`bigimage`                   AS `bigimage`,
  `tb_information`.`ikid`                       AS `ikid`,
  `tb_information`.`head`                       AS `head`,
  `tb_information`.`headtop`                    AS `headtop`,
  `tb_information`.`kindtop`                    AS `kindtop`,
  `tb_information`.`title`                      AS `title`,
  `tb_information`.`summery`                    AS `summery`,
  `tb_information`.`total`                      AS `total`,
  `tb_information`.`state`                      AS `istate`,
  `tb_contract`.`state`                         AS `cstate`
FROM ((`tb_contract_infomation_relation`
    LEFT JOIN `tb_information`
      ON (((`tb_contract_infomation_relation`.`iid` = `tb_information`.`iid`)
           AND (`tb_information`.`deleted` = 0))))
   LEFT JOIN `tb_contract`
     ON (((`tb_contract_infomation_relation`.`cid` = `tb_contract`.`cid`)
          AND (`tb_contract`.`deleted` = 0))))
WHERE (`tb_contract_infomation_relation`.`deleted` = 0)
ORDER BY `tb_contract_infomation_relation`.`startdate` DESC,`tb_contract_infomation_relation`.`cirid` DESC)$$

DELIMITER ;