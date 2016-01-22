<?php

/**
 * This is the model class for table "{{template}}".
 *
 * The followings are the available columns in table '{{template}}':
 * @property integer $tid
 * @property string $creater
 * @property integer $kind
 * @property integer $type
 * @property string $content
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 */
class Template extends XiaoXinActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{template}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('creater, kind', 'required'),
			array('kind, type, state, deleted', 'numerical', 'integerOnly'=>true),
			array('creater', 'length', 'max'=>20),
			array('content, updatetime, creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('tid, creater, kind, type, content, state, creationtime, updatetime, deleted', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tid' => '模版ID',
			'creater' => '模版创建者',
			'kind' => '模版种类(0：系统模版，1：自定义模版)',
			'type' => '模版类型(0，作业，1：表现)',
			'content' => '内容',
			'state' => '状态：暂未使用',
			'creationtime' => '创建时间',
			'updatetime' => '更新时间',
			'deleted' => '是否已删除',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('tid',$this->tid);
		$criteria->compare('creater',$this->creater,true);
		$criteria->compare('kind',$this->kind);
		$criteria->compare('type',$this->type);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function getTemplates($params,$unit=20)
    {
    	$unit = $unit?$unit:20;
        $criteria=new CDbCriteria;
        if(isset($params['kind']) && $params['kind']!==''){
            $criteria->compare('kind',$params['kind']);
        }
        if(isset($params['type']) && $params['type']!==''){
            $criteria->compare('type',$params['type']);
        }
        if(isset($params['creater']) && $params['creater']){
        	if($params['kind']!=0){
        		$criteria->compare('creater',$params['creater']);
        	}
        }
        $criteria->compare('deleted',0);
        if(isset($params['lasttime'])&&!empty($params['lasttime'])){
			$lasttime = date('Y-m-d H:i:s',$params['lasttime']);
			if($params['lastid']){
				$criteria->addCondition("creationtime<'".$lasttime."' OR (creationtime='".$lasttime."' AND tid>".$params['lastid'].")");
			}else{
				$criteria->addCondition("creationtime>'".$lasttime."'");
			}
		}
        $criteria->limit=$unit;
        $criteria->order = 'tid DESC';
        $data = self::model()->findAll($criteria);
        return $data;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Template the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
