<?php
/**
*记录操作日志行为类
*panrj 2014-05-13
 */
class MasterActiveRecordBehavior extends CActiveRecordBehavior
{
    private $_oldattributes = array();
 
    public function afterSave($event)
    {
        // conlog(Yii::app()->request->userHostAddress);
        $plant = Yii::app()->params['platform'];
        $ip = Yii::app()->request->getUserHostAddress();
        if (!$this->Owner->isNewRecord) {
            // 操作已有记录
            $newattributes = $this->Owner->getAttributes();
            $oldattributes = $this->getOldAttributes();
            // compare old and new
            //删除记录
            if(isset($oldattributes['deleted']) && isset($newattributes['deleted']) && $newattributes['deleted'] == 1 && $oldattributes['deleted'] == 0 && get_class($this->Owner)!='User')
            {
                if($plant=='backend'){
                    $log=new Log;
                    $log->action=       'DELETE';
                    $log->table=        get_class($this->Owner);
                    $log->objectid=      $this->Owner->getPrimaryKey();
                    $log->field=        '';
                    $log->uid=       Yii::app()->user->id;
                    $log->ip = $ip;
                    $log->save();
                }
                //前台用户操作日志不管前后台都会记日志到LogNew
                if(get_class($this->Owner)=='Member'){
                    $newlog=new LogNew;
                    $newlog->action=       'DELETE';
                    $newlog->table=        get_class($this->Owner);
                    $newlog->objectid=      $this->Owner->getPrimaryKey();
                    $newlog->field=        '';
                    $newlog->uid=       Yii::app()->user->id;
                    $newlog->platform = $plant=='backend'?0:1;
                    $newlog->creationtime = date("Y-m-d H:i:s");
                    $newlog->ip = $ip;
                    $newlog->save();
                }
            }else{
            //更新记录
                foreach ($newattributes as $name => $value) {
                    if (!empty($oldattributes)) {
                        $old = $oldattributes[$name];
                    } else {
                        $old = '';
                    }
                    //记录更新日志
                    if ($value != $old && $name!='updatetime') {//不更新updatetime字段
                        if($plant=='backend'){
                            $log=new Log;
                            $log->action=       'CHANGE';
                            $log->table=        get_class($this->Owner);
                            $log->objectid=      $this->Owner->getPrimaryKey();
                            $log->field=        $name;
                            $log->olddata=        $old;
                            $log->newdata=        $value;
                            $log->uid=       Yii::app()->user->id;
                            $log->ip = $ip;
                            $log->save();
                        }
                        //前台用户操作日志不管前后台都会记日志到LogNew
                        if(get_class($this->Owner)=='Member'){
                            $newlog=new LogNew;
                            $newlog->action=       'CHANGE';
                            $newlog->table=        get_class($this->Owner);
                            $newlog->objectid=      $this->Owner->getPrimaryKey();
                            $newlog->field=        $name;
                            $newlog->olddata=        $old;
                            $newlog->newdata=        $value;
                            $newlog->uid=       Yii::app()->user->id;
                            $newlog->platform = $plant=='backend'?0:1;
                            $newlog->creationtime = date("Y-m-d H:i:s");
                            $newlog->ip = $ip;
                            $newlog->save();
                        }
                    }
                }
            }
        //新增记录

        } else {
            if($plant=='backend'){
                $log=new Log;
                $log->action=       'CREATE';
                $log->table=        get_class($this->Owner);
                $log->objectid=      $this->Owner->getPrimaryKey();
                $log->field=        '';
                $log->uid=       Yii::app()->user->id;
                $log->ip = $ip;
                $log->save();
            }

            //前台用户操作日志不管前后台都会记日志到LogNew
            if(get_class($this->Owner)=='Member'){
                $newlog=new LogNew;
                $newlog->action=       'CREATE';
                $newlog->table=        get_class($this->Owner);
                $newlog->objectid=      $this->Owner->getPrimaryKey();
                $newlog->field=        '';
                $newlog->uid=       Yii::app()->user->id;
                $newlog->platform = $plant=='backend'?0:1;
                $newlog->creationtime = date("Y-m-d H:i:s");
                $newlog->ip = $ip;
                $newlog->save();
            }
        }
    }
    
    //删除记录
    public function afterDelete($event)
    {
        $ip = Yii::app()->request->getUserHostAddress();
        $plant = Yii::app()->params['platform'];
        if($plant=='backend'){
            $log=new Log;
            $log->action=       'DELETE';
            $log->table=        get_class($this->Owner);
            $log->objectid=      $this->Owner->getPrimaryKey();
            $log->field=        '';
            $log->uid=       Yii::app()->user->id;
            $log->ip = $ip;
            $log->save();
        }
    }
 
    public function afterFind($event)
    {
        // Save old values
        $this->setOldAttributes($this->Owner->getAttributes());
    }
 
    public function getOldAttributes()
    {
        return $this->_oldattributes;
    }
 
    public function setOldAttributes($value)
    {
        $this->_oldattributes=$value;
    }
}