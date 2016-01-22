DELIMITER $$

USE `user_center`$$

DROP VIEW IF EXISTS `view_teacher_info`$$

CREATE ALGORITHM=UNDEFINED DEFINER=`dbManager`@`%` SQL SECURITY DEFINER VIEW `view_teacher_info` AS 
SELECT
  `t`.`userid`       AS `userid`,
  `t`.`name`         AS `username`,
  `t`.`mobilephone`  AS `mobilephone`,
  `t`.`creationtime` AS `creationtime`,
  GROUP_CONCAT(`s`.`sid` SEPARATOR ',') AS `sid`,
  GROUP_CONCAT(`s`.`did` SEPARATOR ',') AS `did`
FROM ((`tb_user` `t`
    LEFT JOIN `view_tb_school_teacher_relation` `s`
      ON ((`t`.`userid` = `s`.`teacher`)))
   LEFT JOIN `tb_school` `sc`
     ON ((`s`.`sid` = `sc`.`sid`)))
WHERE ((`t`.`deleted` = 0)
       AND (`t`.`identity` = 1))
GROUP BY `t`.`userid`$$

DELIMITER ;