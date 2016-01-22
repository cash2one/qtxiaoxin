DELIMITER $$

USE `business_new`$$

DROP VIEW IF EXISTS `view_school_grade`$$

CREATE ALGORITHM=UNDEFINED DEFINER=`dbManager`@`%` SQL SECURITY DEFINER VIEW `view_school_grade` AS (
SELECT `user_center`.`tb_school`.`sid` AS `sid`,`user_center`.`tb_school`.`name` AS `sname`,`user_center`.`tb_school`.`aid` AS `aid`,`user_center`.`tb_school_type`.`stid` AS `stid`,`user_center`.`tb_grade`.`gid` AS `gid`,`user_center`.`tb_grade`.`name` AS `gname`,`user_center`.`tb_grade`.`age` AS `age` FROM ((`user_center`.`tb_school_type` LEFT JOIN `user_center`.`tb_school` ON((FIND_IN_SET(`user_center`.`tb_school_type`.`stid`,`user_center`.`tb_school`.`stid`) AND (`user_center`.`tb_school`.`deleted` = 0)))) JOIN `user_center`.`tb_grade`) WHERE ((`user_center`.`tb_school_type`.`stid` = `user_center`.`tb_grade`.`stid`) AND (`user_center`.`tb_school_type`.`deleted` = 0) AND (`user_center`.`tb_grade`.`deleted` = 0)))$$

DELIMITER ;