<?php
/**
 *  This is a tutorial for how to auto set model values without any code.
 *
 * @createdDate (When record is added)
 * @(IP address from where record is added)
 * @updatedDate (When record is updated)
 * updatedIp (IP address from where record is updated)
 */
class MasterActiveRecord extends CActiveRecord
{   
    public function behaviors()
    {
        return array(
            // YII AR的事件行为
            'MasterActiveRecordBehavior',//记录操作日志
            // 'CTimestampBehavior' => array(
            //     'class' => 'zii.behaviors.CTimestampBehavior',
            //     'createAttribute' => 'creationtime',
            //     'updateAttribute' => 'updatetime',
            // )
        );

    }

    public function beforeSave()
    {       
        if($this->isNewRecord) // only if adding new record
        {
            if($this->hasAttribute('creationtime')) // if model have createdDate Field
                $this->creationtime = date("Y-m-d H:i:s"); // set createdDate value   
            // if($this->hasAttribute('create_ip')) // if model have createdIp Field
            //     $this->create_ip = CHttpRequest::getUserHostAddress(); // set user's ip
        }
 
        if($this->hasAttribute('updatetime')) // if model have updatedDate Field
            $this->updatetime = date("Y-m-d H:i:s"); // set updatedDate value   
        // if($this->hasAttribute('update_ip')) // if model have updatedIp Field
        //     $this->update_ip = CHttpRequest::getUserHostAddress(); // set user's ip

        return parent::beforeSave();
    }

    /**
    * 获得model的类名
    */
    public function getModelClass()
    {
        $modelclass = get_class($this);
        return $modelclass;
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

    public function scopes()
    {
        return array(
            'deleted'=>array(
                'condition'=>'deleted=1',
            ),
            'normal'=>array(
                'condition'=>'deleted=0',
            ),
        );
    }

    public function deleteMark()
    {
        $this->deleted = 1;
        $this->save();
        return $this;
    }

    public function resetMark()
    {
        $this->deleted = 0;
        $this->save();
        return $this;
    }
}
?>