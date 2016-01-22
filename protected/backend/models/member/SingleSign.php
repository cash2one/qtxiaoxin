<?php

/**
 * This is the model class for table "{{single_sign}}".
 *
 * The followings are the available columns in table '{{single_sign}}':
 * @property string $userid
 * @property string $guid
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 */
class SingleSign extends MemberActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{single_sign}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userid, guid', 'required'),
			array('deleted', 'numerical', 'integerOnly'=>true),
			array('userid', 'length', 'max'=>20),
			array('guid', 'length', 'max'=>50),
			array('creationtime, updatetime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('userid, guid, creationtime, updatetime, deleted', 'safe', 'on'=>'search'),
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
			'userid' => '用户ID',
			'guid' => '客户端登录标识',
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

		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('guid',$this->guid,true);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function setGuidByUserid($userid,$guid)
	{
		$model = SingleSign::model()->findByPk($userid);
		if($model){
			$model->guid = $guid;
			$model->save();
			return $model;
		}else{
			$model = new SingleSign;
			$model->userid = $userid;
			$model->guid = $guid;
			$model->save();
			return $model;
		}
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SingleSign the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
