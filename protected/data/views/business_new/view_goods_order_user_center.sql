DELIMITER $$

USE `business_new`$$

DROP VIEW IF EXISTS `view_goods_order_user_center`$$

CREATE ALGORITHM=UNDEFINED DEFINER=`dbManager`@`%` SQL SECURITY DEFINER VIEW `view_goods_order_user_center` AS (
SELECT
  `business_new`.`tb_mall_orders`.`moid`                 AS `moid`,
  `business_new`.`tb_mall_orders`.`state`                AS `state`,
  `business_new`.`tb_mall_orders`.`mcaid`                AS `mcaid`,
  `business_new`.`tb_mall_orders`.`creationtime`         AS `creationtime`,
  `business_new`.`tb_mall_orders`.`userid`               AS `userid`,
  `business_new`.`tb_mall_orders_goods_relation`.`mgid`  AS `mgid`,
  `business_new`.`tb_mall_orders_goods_relation`.`mgcid` AS `mgcid`,
  `business_new`.`tb_mall_goods`.`name`                  AS `mgname`,
  `business_new`.`tb_mall_goods`.`mgkid`                 AS `mgkid`,
  `business_new`.`tb_mall_goods`.`type`                  AS `type`,
  `business_new`.`tb_business`.`bid`                     AS `bid`,
  `business_new`.`tb_business`.`name`                    AS `bname`,
  `business_new`.`tb_point_relation`.`point`             AS `point`
FROM ((((`business_new`.`tb_mall_orders`
        
      LEFT JOIN `business_new`.`tb_mall_orders_goods_relation`
        ON ((`business_new`.`tb_mall_orders`.`moid` = `business_new`.`tb_mall_orders_goods_relation`.`moid`)))
     LEFT JOIN `business_new`.`tb_mall_goods`
       ON ((`business_new`.`tb_mall_orders_goods_relation`.`mgid` = `business_new`.`tb_mall_goods`.`mgid`)))
    LEFT JOIN `business_new`.`tb_point_relation`
      ON (((`business_new`.`tb_mall_orders_goods_relation`.`mgid` = `business_new`.`tb_point_relation`.`tid`)
           AND (`business_new`.`tb_point_relation`.`target` = 'Mall'))))
   LEFT JOIN `business_new`.`tb_business`
     ON ((`business_new`.`tb_mall_goods`.`bid` = `business_new`.`tb_business`.`bid`)))
WHERE (`business_new`.`tb_mall_orders`.`deleted` = 0))$$

DELIMITER ;