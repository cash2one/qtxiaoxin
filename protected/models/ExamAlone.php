<?php
/**
 * This is the model class for table "{{exam_alone}}".
 *
 * The followings are the available columns in table '{{exam_alone}}':
 * @property integer $eaid
 * @property integer $cid
 * @property integer $sid
 * @property string $collate
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 * @property double $average
 * @property integer $sended
 */
class ExamAlone extends XiaoXinActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{exam_alone}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cid, sid, collate', 'required'),
			array('cid, sid, state, deleted, sended', 'numerical', 'integerOnly'=>true),
			array('average', 'numerical'),
			array('collate', 'length', 'max'=>50),
			array('updatetime,creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('eaid, cid, sid, collate, state, creationtime, updatetime, deleted, average, sended', 'safe', 'on'=>'search'),
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
			'eaid' => '单班单科考试ID',
			'cid' => '班级',
			'sid' => '科目',
			'collate' => '核对',
			'state' => '状态',
			'creationtime' => '创建时间',
			'updatetime' => '更新时间',
			'deleted' => '是否已删除',
			'average' => '平均分',
			'sended' => '是否已通知家长',
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

		$criteria->compare('eaid',$this->eaid);
		$criteria->compare('cid',$this->cid);
		$criteria->compare('sid',$this->sid);
		$criteria->compare('collate',$this->collate,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('average',$this->average);
		$criteria->compare('sended',$this->sended);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public static function getExamAndAloneInfo1($eaids){
        return NoticeQuery::queryAll("select t.*,te.eid,te.eaid from tb_exam_alone t  inner join tb_exam_alone_relation te on
            t.eaid=te.eaid where  te.eaid in($eaids) and t.deleted=0 and te.deleted=0");
    }
    public static function getExamAndAloneInfo($cid,$sid,$eid){
        return NoticeQuery::queryRow("select t.*,te.eid from tb_exam_alone t  inner join tb_exam_alone_relation te on
            t.eaid=te.eaid where sid=$sid and cid=$cid and te.eid=$eid and t.deleted=0 and te.deleted=0");
    }

    public static function getExamAloneList($eid){
        return NoticeQuery::queryAll("select t.*,te.eid from tb_exam_alone t  inner join tb_exam_alone_relation te on
            t.eaid=te.eaid where  te.eid=$eid and t.deleted=0 and te.deleted=0");
    }

    public static function getExamAloneByMd5($md5)
    {
        $criteria=new CDbCriteria;
        $criteria->compare('`collate`',$md5);
        $criteria->compare('deleted',0);
        return self::model()->find($criteria);
    }
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ExamAlone the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


}
