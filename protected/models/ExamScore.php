<?php

/**
 * This is the model class for table "{{exam_score}}".
 *
 * The followings are the available columns in table '{{exam_score}}':
 * @property integer $esid
 * @property string $userid
 * @property double $score
 * @property integer $eaid
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 */
class ExamScore extends XiaoXinActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{exam_score}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userid, score, eaid', 'required'),
			array('eaid, state, deleted', 'numerical', 'integerOnly'=>true),
			array('score', 'numerical'),
			array('userid', 'length', 'max'=>20),
			array('updatetime,creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('esid, userid, score, eaid, state, creationtime, updatetime, deleted', 'safe', 'on'=>'search'),
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
			'esid' => '主键',
			'userid' => '学生',
			'score' => '分数',
			'eaid' => '所属单科考试id',
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

		$criteria->compare('esid',$this->esid);
		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('score',$this->score);
		$criteria->compare('eaid',$this->eaid);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public static function getExamScoreByEaid($eaid){
        $criteria=new CDbCriteria;
        $criteria->compare('eaid',$eaid);
        $criteria->compare('deleted',0);
        $data= self::model()->findAll($criteria);
        $cid=NoticeQuery::queryRow("select cid from tb_exam_alone where eaid=$eaid");
        $classstudents=array();
        if($cid){
            $classstudentobject=ClassStudentRelation::getClassStudents($cid);
            foreach($classstudentobject as $val){
                $classstudents[]=$val->student;
            }
        }
        $result=array();
        foreach($data as $val){
            $member=Member::model()->findByPk(($val->userid));
            if($member&&$member->deleted==0&&$member->state==1){
                if(in_array($member->userid,$classstudents)){
                    $result[$val->userid]=$val->score;
                }
            }
        }
        return $result;
    }

    public static function getScoreByEaid($eaid){
        $criteria=new CDbCriteria;
        $criteria->compare('eaid',$eaid);
        $criteria->compare('deleted',0);
        $data= self::model()->findAll($criteria);

        return $data;
    }


    public static function getExamScoreByEaidAndUserid($eaid,$userid){
        $criteria=new CDbCriteria;
        $criteria->compare('eaid',$eaid);
        $criteria->compare('userid',$userid);
        $criteria->compare('deleted',0);
        $data= self::model()->find($criteria);
        return $data;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ExamScore the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
