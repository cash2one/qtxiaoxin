DELIMITER $$

USE `user_center`$$

DROP VIEW IF EXISTS `view_student_guardian`$$

CREATE ALGORITHM=UNDEFINED DEFINER=`dbManager`@`%` SQL SECURITY DEFINER VIEW `view_student_guardian` AS 
SELECT
  `g`.`child`    AS `child`,
  `g`.`guardian` AS `guardian`,
  GROUP_CONCAT(`u`.`mobilephone` SEPARATOR ',') AS `mobilephone`
FROM (`tb_guardian` `g`
   LEFT JOIN `tb_user` `u`
     ON ((`g`.`guardian` = `u`.`userid`)))
WHERE ((`u`.`deleted` = 0)
       AND (`g`.`deleted` = 0))
GROUP BY `g`.`child`$$

DELIMITER ;