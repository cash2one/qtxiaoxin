<?php

/**
 * This is the model class for table "view_api_infomration_relation".
 *
 * The followings are the available columns in table 'view_api_infomration_relation':
 * @property integer $cirid
 * @property integer $cid
 * @property integer $iid
 * @property string $startdate
 * @property string $image
 * @property string $bigimage
 * @property integer $ikid
 * @property integer $head
 * @property integer $headtop
 * @property string $title
 * @property string $summery
 * @property integer $istate
 * @property integer $cstate
 */
class ViewApiInfomrationRelation extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'view_api_infomration_relation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('iid', 'required'),
			array('cirid, cid, iid, ikid, head, headtop, istate, cstate', 'numerical', 'integerOnly'=>true),
			array('image, bigimage', 'length', 'max'=>50),
			array('title', 'length', 'max'=>20),
			array('summery', 'length', 'max'=>30),
			array('startdate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('cirid, cid, iid, startdate, image, bigimage, ikid, head, headtop, title, summery, istate, cstate', 'safe', 'on'=>'search'),
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
			'cirid' => '关系ID',
			'cid' => '合同',
			'iid' => '资讯',
			'startdate' => '开始时间',
			'image' => '图片',
			'bigimage' => '大图片',
			'ikid' => '资讯种类',
			'head' => '头条',
			'headtop' => '头条置顶',
			'title' => '标题',
			'summery' => '摘要',
			'istate' => '状态',
			'cstate' => '状态',
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

		$criteria->compare('cirid',$this->cirid);
		$criteria->compare('cid',$this->cid);
		$criteria->compare('iid',$this->iid);
		$criteria->compare('startdate',$this->startdate,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('bigimage',$this->bigimage,true);
		$criteria->compare('ikid',$this->ikid);
		$criteria->compare('head',$this->head);
		$criteria->compare('headtop',$this->headtop);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('summery',$this->summery,true);
		$criteria->compare('istate',$this->istate);
		$criteria->compare('cstate',$this->cstate);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ViewApiInfomrationRelation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
