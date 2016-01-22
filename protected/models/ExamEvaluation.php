<?php

/**
 * This is the model class for table "{{exam_evaluation}}".
 *
 * The followings are the available columns in table '{{exam_evaluation}}':
 * @property integer $eeid
 * @property string $userid
 * @property string $evaluation
 * @property integer $eid
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 */
class ExamEvaluation extends XiaoXinActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{exam_evaluation}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userid, eid', 'required'),
			array('eid, state, deleted', 'numerical', 'integerOnly'=>true),
			array('userid', 'length', 'max'=>20),
			array('evaluation, updatetime,creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('eeid, userid, evaluation, eid, state, creationtime, updatetime, deleted', 'safe', 'on'=>'search'),
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
			'eeid' => '主键',
			'userid' => '学生',
			'evaluation' => '考试评价',
			'eid' => '考试',
			'state' => '状态',
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

		$criteria->compare('eeid',$this->eeid);
		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('evaluation',$this->evaluation,true);
		$criteria->compare('eid',$this->eid);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public static function getExamEvaluation($eid){
        $criteria=new CDbCriteria;
        $criteria->compare('eid',$eid);
        $criteria->compare('deleted',0);
        $data= self::model()->findAll($criteria);
        $arr=array();
        foreach($data as $val){
            $arr[$val->userid]=$val->evaluation;
        }
        return $arr;
    }

    public static function getUserExamEvaluation($eid,$userid){
        $criteria=new CDbCriteria;
        $criteria->compare('eid',$eid);
        $criteria->compare('userid',$userid);
        $criteria->compare('deleted',0);
        $data= self::model()->find($criteria);
        return $data;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ExamEvaluation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
