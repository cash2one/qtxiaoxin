<?php

/**
 * This is the model class for table "view_focus_relation_count".
 *
 * The followings are the available columns in table 'view_focus_relation_count':
 * @property integer $fid
 * @property string $title
 * @property string $summery
 * @property string $text
 * @property string $image
 * @property string $url
 * @property integer $bid
 * @property integer $uid
 * @property integer $type
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 * @property integer $total
 * @property string $connum
 */
class ViewFocusRelationCount extends Focus
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'view_focus_relation_count';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, summery, image, url, uid, type', 'required'),
			array('fid, bid, uid, type, state, deleted, total', 'numerical', 'integerOnly'=>true),
			array('title, image, url', 'length', 'max'=>64),
			array('summery', 'length', 'max'=>256),
			array('connum', 'length', 'max'=>21),
			array('text, creationtime, updatetime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('fid, title, summery, text, image, url, bid, uid, type, state, creationtime, updatetime, deleted, total, connum', 'safe', 'on'=>'search'),
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
			'fid' => '热点ID',
			'title' => '标题',
			'summery' => '摘要',
			'text' => '文字',
			'image' => '图片',
			'url' => '外链地址',
			'bid' => '商户',
			'uid' => '创建者',
			'type' => '类别：0文章；1问卷',
			'state' => '状态',
			'creationtime' => '创建时间',
			'updatetime' => '更新时间',
			'deleted' => '已删除',
			'total' => '参与人次',
			'connum' => 'Connum',
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

		$criteria->compare('fid',$this->fid);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('summery',$this->summery,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('bid',$this->bid);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('type',$this->type);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('total',$this->total);
		$criteria->compare('connum',$this->connum,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ViewFocusRelationCount the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
