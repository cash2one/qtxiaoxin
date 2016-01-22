<?php

/**
 * This is the model class for table "{{focus_question}}".
 *
 * The followings are the available columns in table '{{focus_question}}':
 * @property integer $fqid
 * @property integer $fid
 * @property string $title
 * @property integer $type
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property Focus $f
 * @property FocusQuestionItem[] $focusQuestionItems
 */
class FocusQuestion extends MasterActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{focus_question}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fid, title, type', 'required'),
			array('fid, type, state, deleted', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>50),
			array('updatetime, creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('fqid, fid, title, type, state, creationtime, updatetime, deleted', 'safe', 'on'=>'search'),
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
			'f' => array(self::BELONGS_TO, 'Focus', 'fid'),
			'focusQuestionItems' => array(self::HAS_MANY, 'FocusQuestionItem', 'fqid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'fqid' => '题目ID',
			'fid' => '热点',
			'title' => '标题',
			'type' => '题目类型：0单选；1多选；2问答；',
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

		$criteria->compare('fqid',$this->fqid);
		$criteria->compare('fid',$this->fid);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getQuestionItems()
	{
		$criteria=new CDbCriteria;
		$criteria->scopes='normal';
		$criteria->compare('fqid',$this->fqid);
		$data = FocusQuestionItem::model()->findAll($criteria);
		return $data;
	}

	public function deleteQuestionItems()
	{
		$items = $this->getQuestionItems();
		if(count($items)){
			foreach($items as $t){
				$t->deleteMark();
			}
		}
	}

	public function getQuestionTypeName()
	{
		$arr = array('0'=>'单选','1'=>'多选','2'=>'问答',);
		return $arr[$this->type];
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FocusQuestion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
