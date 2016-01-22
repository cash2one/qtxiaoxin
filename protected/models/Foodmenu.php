<?php

/**
 * This is the model class for table "{{foodmenu}}".
 *
 * The followings are the available columns in table '{{foodmenu}}':
 * @property string $id
 * @property string $sid
 * @property integer $week
 * @property string $content
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 * @property integer $state
 * @property integer $ispublish
 */
class Foodmenu extends XiaoXinActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{foodmenu}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('week, deleted, state, ispublish', 'numerical', 'integerOnly'=>true),
			array('sid', 'length', 'max'=>20),
			array('content', 'length', 'max'=>1500),
			array('creationtime, updatetime,updatetime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sid, week, content, creationtime, updatetime, deleted, state, ispublish,updatetime', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'sid' => '学校id',
			'week' => '当年中第几周',
			'content' => '餐单内容(json格式星期一到星期天餐单内容)',
			'creationtime' => 'Creationtime',
			'updatetime' => 'Updatetime',
			'deleted' => '是否已删除(1--已删除)',
			'state' => '保留字段',
			'ispublish' => '是否已发布(1--忆发布,0未发布)',
			'publishnum' => '发布次数',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('sid',$this->sid,true);
		$criteria->compare('week',$this->week);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('state',$this->state);
		$criteria->compare('ispublish',$this->ispublish);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public static function getFoodContent($params)
    {
        $criteria=new CDbCriteria;
        if(isset($params['sid']) && $params['sid']){
            $criteria->compare('sid',$params['sid']);
        }
        if(isset($params['week']) && $params['week']){
            $criteria->compare('week',$params['week']);
        }
        if(isset($params['year']) && $params['year']){
            $criteria->compare('year',$params['year']);
        }
        $criteria->compare('deleted',0);
        $data = self::model()->find($criteria);
        return $data;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Foodmenu the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
