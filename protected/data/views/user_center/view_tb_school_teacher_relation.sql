DELIMITER $$

USE `user_center`$$

DROP VIEW IF EXISTS `view_tb_school_teacher_relation`$$

CREATE ALGORITHM=UNDEFINED DEFINER=`dbManager`@`%` SQL SECURITY DEFINER VIEW `view_tb_school_teacher_relation` AS 
SELECT
  `tb_school_teacher_relation`.`id`           AS `id`,
  `tb_school_teacher_relation`.`sid`          AS `sid`,
  `tb_school_teacher_relation`.`teacher`      AS `teacher`,
  `tb_school_teacher_relation`.`state`        AS `state`,
  `tb_school_teacher_relation`.`creationtime` AS `creationtime`,
  `tb_school_teacher_relation`.`updatetime`   AS `updatetime`,
  `tb_school_teacher_relation`.`deleted`      AS `deleted`,
  `tb_school_teacher_relation`.`did`          AS `did`
FROM `tb_school_teacher_relation`
WHERE (`tb_school_teacher_relation`.`deleted` = 0)$$

DELIMITER ;