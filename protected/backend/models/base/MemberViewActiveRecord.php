<?php
/**
 */
class MemberViewActiveRecord extends CActiveRecord
{    
    public static $db;
    private $db_conn = 'db_member';
    /*
    AR链接多个数据库

    If you want to use an application component other than db, or if you want to work with multiple databases using AR, you should override CActiveRecord::getDbConnection(). The CActiveRecord class is the base class for all AR classes.

    Tip: There are two ways to work with multiple databases in AR. If the schemas of the databases are different, you may create different base AR classes with different implementation of getDbConnection(). Otherwise, dynamically changing the static variable CActiveRecord::db is a better idea.

    */
    public function getDbConnection()
    {
        if(self::$db!==null)
            return self::$db;
        else
        {
            self::$db=Yii::app()->getComponent($this->db_conn);
            if(self::$db instanceof CDbConnection)
            {
                self::$db->setActive(true);
                return self::$db;
            }
            else
                throw new CDbException(Yii::t('yii','Active Record requires a "db" CDbConnection application component.'));
        }
    }

    /**
     * 根据主键获得model
     */
    public function loadByPk($pk)
    {
        $model = $this->findByPk($pk);
        if(empty($model) or $model->deleted == 1)
        {
            // 该记录已删除或不存在
            throw new CHttpException(404,'...您访问的页面不存在.');
        }
        return $model;
    }

    public function deleteMark()
    {
        $this->deleted = 1;
        $this->save();
        return $this;
    }
}
?>