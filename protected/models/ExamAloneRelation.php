<?php
/**
 * This is the model class for table "{{exam_alone_relation}}".
 *
 * The followings are the available columns in table '{{exam_alone_relation}}':
 * @property integer $earid
 * @property integer $eid
 * @property integer $eaid
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 */
class ExamAloneRelation extends XiaoXinActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{exam_alone_relation}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('eid, eaid', 'required'),
			array('eid, eaid, state, deleted', 'numerical', 'integerOnly'=>true),
			array('updatetime,creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('earid, eid, eaid, state, creationtime, updatetime, deleted', 'safe', 'on'=>'search'),
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
			'earid' => '主键',
			'eid' => '考试',
			'eaid' => '单班单科考试',
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

		$criteria->compare('earid',$this->earid);
		$criteria->compare('eid',$this->eid);
		$criteria->compare('eaid',$this->eaid);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    public static function getRelationByEidEaid($eid,$eaid){
        $criteria=new CDbCriteria;
        $criteria->compare('eid',$eid);
        $criteria->compare('eaid',$eaid);
        $criteria->compare('deleted',0);
        return self::model()->find($criteria);
    }

    public static function getRelationByEaid($eaid){
        return NoticeQuery::queryAll("select t.*,te.eid from tb_exam_alone t  inner join tb_exam_alone_relation te on
            t.eaid=te.eaid where  te.eaid=$eaid and t.deleted=0 and te.deleted=0");

        $criteria=new CDbCriteria;
        $criteria->compare('eaid',$eaid);
        $criteria->compare('deleted',0);
        return self::model()->findAll($criteria);
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ExamAloneRelation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}




}
