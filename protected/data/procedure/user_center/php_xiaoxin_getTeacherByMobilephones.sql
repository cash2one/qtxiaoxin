DELIMITER $$

USE `user_center_new` $$

DROP PROCEDURE IF EXISTS `php_xiaoxin_getTeacherByMobilephones` $$

CREATE DEFINER = `dbManager` @`%` PROCEDURE `php_xiaoxin_getTeacherByMobilephones` (p_mobilephones TEXT, p_sid INT) 
BEGIN
  SELECT 
    userid AS teacher 
  FROM
    `tb_user` 
    LEFT JOIN `tb_school_teacher_relation` 
      ON (
        `tb_school_teacher_relation`.`teacher` = `tb_user`.`userid` 
        AND `tb_school_teacher_relation`.`sid` = p_sid
      ) 
  WHERE FIND_IN_SET(mobilephone, p_mobilephones) 
    AND `tb_user`.`deleted` = 0 
    AND `tb_user`.`state` = 1 
    AND (`tb_user`.`identity` = 1 OR `tb_user`.`identity` = 5)
    AND `tb_school_teacher_relation`.`sid` = p_sid 
    AND `tb_school_teacher_relation`.`deleted` = 0 ;
END $$

DELIMITER ;

