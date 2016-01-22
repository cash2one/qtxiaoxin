DELIMITER $$

USE `user_center`$$

DROP VIEW IF EXISTS `view_student_info`$$

CREATE ALGORITHM=UNDEFINED DEFINER=`dbManager`@`%` SQL SECURITY DEFINER VIEW `view_student_info` AS 
SELECT
  `u`.`userid`       AS `userid`,
  `u`.`creationtime` AS `creationtime`,
  `u`.`name`         AS `name`,
  GROUP_CONCAT(`cs`.`cid` SEPARATOR ',') AS `cid`,
  GROUP_CONCAT(`c`.`sid` SEPARATOR ',') AS `sid`,
  `gg`.`mobilephone` AS `mobilephone`
FROM (((`tb_user` `u`
     LEFT JOIN `view_tb_class_student_relation` `cs`
       ON ((`u`.`userid` = `cs`.`student`)))
    LEFT JOIN `tb_class` `c`
      ON ((`cs`.`cid` = `c`.`cid`)))
   LEFT JOIN `view_student_guardian` `gg`
     ON ((`u`.`userid` = `gg`.`child`)))
WHERE ((`u`.`identity` = 2)
       AND (`u`.`deleted` = 0))
GROUP BY `u`.`userid`$$

DELIMITER ;