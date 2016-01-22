DELIMITER $$

USE `business_new`$$

DROP VIEW IF EXISTS `view_api_focus_relation`$$

CREATE ALGORITHM=UNDEFINED DEFINER=`dbManager`@`%` SQL SECURITY DEFINER VIEW `view_api_focus_relation` AS (
SELECT
  `tb_contract_focus_relation`.`cfrid`     AS `cfrid`,
  `tb_contract_focus_relation`.`cid`       AS `cid`,
  `tb_contract_focus_relation`.`fid`       AS `fid`,
  `tb_contract_focus_relation`.`startdate` AS `startdate`,
  `tb_contract_focus_relation`.`enddate`   AS `enddate`,
  `tb_focus`.`bid`                         AS `bid`,
  `tb_focus`.`type`                        AS `type`,
  `tb_focus`.`url`                         AS `url`,
  `tb_focus`.`title`                       AS `title`,
  `tb_focus`.`summery`                     AS `summery`,
  `tb_focus`.`image`                       AS `image`,
  `tb_focus`.`creationtime`                AS `ctime`,
  `tb_focus`.`state`                       AS `fstate`,
  `tb_contract`.`state`                    AS `cstate`
FROM ((`tb_contract_focus_relation`
    LEFT JOIN `tb_focus`
      ON (((`tb_contract_focus_relation`.`fid` = `tb_focus`.`fid`)
           AND (`tb_focus`.`deleted` = 0))))
   LEFT JOIN `tb_contract`
     ON (((`tb_contract_focus_relation`.`cid` = `tb_contract`.`cid`)
          AND (`tb_contract`.`deleted` = 0))))
WHERE (`tb_contract_focus_relation`.`deleted` = 0)
ORDER BY `tb_contract_focus_relation`.`startdate` DESC,`tb_contract_focus_relation`.`cfrid` DESC)$$

DELIMITER ;