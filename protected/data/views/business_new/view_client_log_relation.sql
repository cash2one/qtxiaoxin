DELIMITER $$

USE `business_new`$$

DROP VIEW IF EXISTS `view_client_log_relation`$$

CREATE ALGORITHM=UNDEFINED DEFINER=`dbManager`@`%` SQL SECURITY DEFINER VIEW `view_client_log_relation` AS (
SELECT
  `a`.`clid`         AS `clid`,
  `a`.`mobilephone`  AS `mobilephone`,
  `a`.`target`       AS `target`,
  `a`.`tid`          AS `tid`,
  `a`.`action`       AS `action`,
  `a`.`creationtime` AS `creationtime`,
  `b`.`sid`          AS `sid`,
  `b`.`gid`          AS `gid`,
  `c`.`aid`          AS `aid`,
  `d`.`cid`          AS `cid`
FROM (((`tb_client_log` `a`
     LEFT JOIN `tb_phone_school_grade_relation` `b`
       ON ((`a`.`mobilephone` = `b`.`phone`)))
    LEFT JOIN `tb_school` `c`
      ON ((`b`.`sid` = `c`.`sid`)))
   LEFT JOIN `tb_area` `d`
     ON ((`c`.`aid` = `d`.`aid`))))$$

DELIMITER ;