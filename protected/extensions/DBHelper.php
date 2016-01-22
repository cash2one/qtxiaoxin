<?php
/**
 * Created by PhpStorm.
 * User: zhoujunsheng
 * Date: 14-7-28
 * Time: 上午9:13
 */

class DBHelper
{
    public static function getDb()
    {
        return Yii::app()->db;
    }

    /*
     *查询某个表数据，不使用activeRecore,主要是那个经常有意无意fetch所有字段
     */
    public static function fetchAll($table, $where, $filed = "*", $order = null, $sort = "ASC", $limit = "20")
    {
        if (empty($filed)) {
            $field = "*";
        }
        if (is_array($filed)) {
            $sql = "select  " . implode(",", $filed) . " from $table where 1=1 ";
        } else {
            $sql = "select  $field from $table where 1=1 ";
        }
        if (is_array($where)) {
            foreach ($where as $k => $v) {
                $sql = " and `$k`='$v'";
            }
        } else {
            $sql .= $where;
        }
        if ($order) {
            $sql .= " order by $order";
        }
        if ($order && $sort) {
            $sql .= $sort;
        }
        if ($limit) {
            $sql .= " limit " . $limit;
        }
        $db = self::getDb();
        return $db->createCommand($sql)->queryAll();
    }

    /*
     *select field from table where userName=:userName and passowrd=:password
     * 要确保$where是数组形式,参数绑定形式，避免sql注入
     * fetchAllByParams("good",array(':userName'=>'zhou',':password'=>'aaa'));
     */
    public static function fetchAllBindParams($table, $where, $filed = "*", $order = null, $sort = "ASC", $limit = "20")
    {
        if (empty($filed)) {
            $field = "*";
        }

        if (is_array($filed)) {
            $sql = "select  " . implode(",", $filed) . " from $table where 1=1 ";
        } else {
            $sql = "select  " . $filed . " from {$table} where 1=1 ";
        }
        if (is_array($where)) {
            foreach ($where as $k => $v) {
                $ff = ltrim($k, ":");
                $sql = $sql . " and $ff=$k";
            }
        }
        if ($order) {
            $sql .= " order by $order ";
        }
        if ($order && $sort) {
            $sql .= " " . $sort;
        }
        if ($limit) {
            $sql .= " limit " . $limit;
        }
        $db = self::getDb();
        $results = $db->createCommand($sql)->query($where);
        $returnValue = array();
        foreach ($results as $result) {
            $returnValue[] = $result;
        }
        return $returnValue;


    }

    /*
     * 统计指定条件数据，
     * $isBindParams－－是否绑定参数,绑定参数形式，$where要传类似于array(':userName'=>'xxx');
     */

    public static function count($table, $where, $isBindParams = false)
    {
        $sql = "select count(*) as num from $table where 1=1 ";
        if (!empty($where)) {

            if (is_array($where)) {
                foreach ($where as $k => $v) {
                    if (!$isBindParams) {
                        $sql = " and `$k`='$v'";
                    } else {
                        $ff = ltrim($k, ":");
                        $sql = $sql . " and $ff=$k";
                    }
                }
            } else if (is_string($where)) {
                $sql .= $where;
            }
        }
        $db = self::getDb();
        if ($isBindParams) {
            $results = $db->createCommand($sql)->queryScalar($where);
        } else {
            $results = $db->createCommand($sql)->queryScalar();
        }

    }

    /*
     *原生绑定参数形式
     */
    public static function select($sql, $params)
    {
        $db = self::getDb();
        $results = $db->createCommand($sql)->query($params);
        $returnValue = array();
        foreach ($results as $result) {
            $returnValue[] = $result;
        }
        return $returnValue;
    }

    public static function execute($sql, $params)
    {
        $db = self::getDb();
        $results = $db->createCommand($sql)->execute($params);
        return $results;

    }

    public static function fetchRow($table, $where, $filed = "*", $order = "id", $sort = "ASC", $limit = "1")
    {
        $results = self::fetchAll(table, $where, $filed = "*", $order, $sort, $limit);
        return $results[0];
    }

    public static function selectRow($sql, $params)
    {
        $db = self::getDb();
        $results = self::select($sql, $params);
        return $results[0];

    }

    /*
     * 批量插入
     * array(array('name'=>'li','age'=>18),array('name'=>'he','age'=>21));
     * 转成 insert into table(name,age)values('li',18),('hu',21);
     */
    public static function insert_multi($table, $data)
    {
        $db = self::getDb();
        $sql = "INSERT into $table(";
        $values = "";
        foreach ($data[0] as $k => $v) {
            $sql .= "`$k`,";
        }
        $sql = rtrim($sql, ",");
        $sql .= ")";
        foreach ($data as $k => $v) {
            $row = array();
            foreach ($v as $t => $tv) {
                $row[] = "'$tv'";
            }
            $values[] = "(" . implode(",", $row) . ")";
        }
        $sql .= (implode(",", $values));
        return $db->createCommand($sql)->execute();
    }

    /*
     * 单行插入
     */
    public static function insert($table, $data, $get_last_id = 0)
    {
        $db = self::getDb();
        $sql = "INSERT into $table(";
        $values = "";
        foreach ($data as $k => $v) {
            $sql .= "`$k`,";
            $values = "'$v',";
        }
        $sql = rtrim($sql, ",");
        $sql .= ")values(";
        $sql .= rtrim($values, ",") . ")";
        //是否返回id
        if (!$get_last_id) {
            return $db->createCommand($sql)->execute();
        } else {
            $db->createCommand($sql)->execute();
            return $db->createCommand("select last_insert_id;")->queryScalar();
        }
    }

    /*
     * 批量更新
     */
    public static function update($table, $where, $data, $isBindParams = fasle)
    {
        $db = self::getDb();
        $sql = "update $table set ";
        if (empty($data)) {
            error_log("非法更新:" . $table . " where:" . json_encode($where) . " data:");
            return false;
        }
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $sql = " `$k`='" . $v . "'";
            }
        } else if (is_string($data)) {
            $sql .= $data;
        } else {

        }
        $sql .= " where 1=1 ";
        if (empty($where)) { //没有条件，禁止更新
            echo "危险,更新语句后面没条件";
            die();
        }
        if (is_array($where)) {
            foreach ($where as $k => $v) {
                if (!$isBindParams) {
                    $sql .= " AND `$k`='" . $v . "'";
                } else {
                    $ff = ltrim($k, ":"); //参数绑定时:userName=>'xxxx',但字段名，要去掉:号　　update table xxx set xx=yy where userName=:userName
                    $sql .= " AND `$ff`='" . $k . "'";
                }

            }
        } else if (is_string($where)) {
            $sql .= $where;
        } else {

        }
        if (!$isBindParams) {
            return $db->createCommand($sql)->execute();
        } else {
            return $db->createCommand($sql)->execute($where);
        }
    }

    /*
     * 批量删除
     */
    public static function delete($table, $where, $isBindParams = fasle)
    {
        $db = self::getDb();
        $sql = " DELETE from $table  where 1=1 ";
        if (empty($where)) { //没有条件，禁止删除
            die("DELETE from $table  where 1=1 ,危险,删除语句后面没条件");
        }
        if (is_array($where)) {
            foreach ($where as $k => $v) {
                if (!$isBindParams) {
                    $sql .= " AND `$k`='" . $v . "'";
                } else {
                    $ff = ltrim($k, ":"); //参数绑定时:userName=>'xxxx',但字段名，要去掉:号　　delete from table where userName=:userName
                    $sql .= " AND `$ff`='" . $k . "'";
                }
            }
        } else if (is_string($where)) {
            $sql .= $where;
        }
        if (!$isBindParams) {
            return $db->createCommand($sql)->execute();
        } else {
            return $db->createCommand($sql)->execute($where);
        }
    }

    public static function getTrascation()
    {
        $db = self::getDb();
        $transaction = $db->beginTransaction(); //创建事务
        return $transaction;
    }

    public static function beginTransaction()
    {
        self::getTrascation()->beginTransaction();
    }

    public static function commit()
    {
        self::getTrascation()->commit();
    }

    public static function rollback()
    {
        self::getTrascation()->rollback();
    }
}