<?php

/**
 * This is the model class for table "view_api_focus_relation".
 *
 * The followings are the available columns in table 'view_api_focus_relation':
 * @property integer $cfrid
 * @property integer $cid
 * @property integer $fid
 * @property string $startdate
 * @property string $enddate
 * @property integer $bid
 * @property integer $type
 * @property string $url
 * @property string $title
 * @property string $summery
 * @property string $image
 * @property integer $fstate
 * @property integer $cstate
 */
class ViewApiFocusRelation extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'view_api_focus_relation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fid', 'required'),
			array('cfrid, cid, fid, bid, type, fstate, cstate, top', 'numerical', 'integerOnly'=>true),
			array('url, title, image', 'length', 'max'=>64),
			array('summery', 'length', 'max'=>256),
			array('startdate, enddate, ctime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('cfrid, cid, fid, startdate, enddate, bid, type, url, title, summery, image, ctime, fstate, cstate, top', 'safe', 'on'=>'search'),
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
			'cfrid' => '关系ID',
			'cid' => '合同',
			'fid' => '热点',
			'startdate' => '开始时间',
			'enddate' => '结束时间',
			'bid' => '商户',
			'type' => '类别：0文章；1问卷',
			'url' => '外链地址',
			'title' => '标题',
			'top' => '是否置顶',
			'summery' => '摘要',
			'image' => '图片',
			'ctime' => '创建时间',
			'fstate' => '状态：0非开放热点，无状态；1启用；2停用',
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

		$criteria->compare('cfrid',$this->cfrid);
		$criteria->compare('cid',$this->cid);
		$criteria->compare('fid',$this->fid);
		$criteria->compare('startdate',$this->startdate,true);
		$criteria->compare('enddate',$this->enddate,true);
		$criteria->compare('bid',$this->bid);
		$criteria->compare('type',$this->type);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('summery',$this->summery,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('fstate',$this->fstate);
		$criteria->compare('cstate',$this->cstate);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ViewApiFocusRelation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
