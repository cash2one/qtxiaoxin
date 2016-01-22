<?php

/**
 * This is the model class for table "{{information_comment}}".
 *
 * The followings are the available columns in table '{{information_comment}}':
 * @property integer $icid
 * @property string $text
 * @property string $userid
 * @property integer $iid
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property Information $i
 * @property Client $userid0
 */
class InformationComment extends MasterActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{information_comment}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userid, iid', 'required'),
			array('userid, iid, state, deleted', 'numerical', 'integerOnly'=>true),
			array('text, updatetime, creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('icid, text, userid, iid, state, creationtime, updatetime, deleted', 'safe', 'on'=>'search'),
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
			'i' => array(self::BELONGS_TO, 'Information', 'iid'),
			'userid0' => array(self::BELONGS_TO, 'Client', 'userid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'icid' => '评论ID',
			'text' => '评论内容',
			'userid' => '用户手机',
			'iid' => '资讯',
			'state' => '状态',
			'creationtime' => '创建时间',
			'updatetime' => '更新时间',
			'deleted' => '已删除',
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

		$criteria->compare('icid',$this->icid);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('iid',$this->iid);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function AddComment($uid,$iid,$text)
	{
		$model = new InformationComment;
		$model->userid = $uid;
		$model->iid = $iid;
		$model->text = $text;
		$model->save();
		if($model->icid){
			$info = $model->i;
			$info->total += 1;
			$info->save();
		}
		return $model;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InformationComment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
