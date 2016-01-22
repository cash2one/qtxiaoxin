DELIMITER $$

USE `user_center`$$

DROP VIEW IF EXISTS `view_school_grade`$$

CREATE ALGORITHM=UNDEFINED DEFINER=`dbManager`@`%` SQL SECURITY DEFINER VIEW `view_school_grade` AS (
SELECT `tb_school`.`sid` AS `sid`,`tb_school`.`name` AS `sname`,`tb_school`.`aid` AS `aid`,`tb_school_type`.`stid` AS `stid`,`tb_grade`.`gid` AS `gid`,`tb_grade`.`name` AS `gname`,`tb_grade`.`age` AS `age` FROM ((`tb_school_type` LEFT JOIN `tb_school` ON((FIND_IN_SET(`tb_school_type`.`stid`,`tb_school`.`stid`) AND (`tb_school`.`deleted` = 0)))) JOIN `tb_grade`) WHERE ((`tb_school_type`.`stid` = `tb_grade`.`stid`) AND (`tb_school_type`.`deleted` = 0) AND (`tb_grade`.`deleted` = 0)))$$

DELIMITER ;