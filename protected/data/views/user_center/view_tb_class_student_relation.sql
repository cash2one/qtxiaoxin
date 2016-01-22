DELIMITER $$

USE `user_center`$$

DROP VIEW IF EXISTS `view_tb_class_student_relation`$$

CREATE ALGORITHM=UNDEFINED DEFINER=`dbManager`@`%` SQL SECURITY DEFINER VIEW `view_tb_class_student_relation` AS 
SELECT
  `tb_class_student_relation`.`id`           AS `id`,
  `tb_class_student_relation`.`cid`          AS `cid`,
  `tb_class_student_relation`.`student`      AS `student`,
  `tb_class_student_relation`.`state`        AS `state`,
  `tb_class_student_relation`.`creationtime` AS `creationtime`,
  `tb_class_student_relation`.`updatetime`   AS `updatetime`,
  `tb_class_student_relation`.`deleted`      AS `deleted`,
  `tb_class_student_relation`.`creater`      AS `creater`
FROM `tb_class_student_relation`
WHERE (`tb_class_student_relation`.`deleted` = 0)$$

DELIMITER ;