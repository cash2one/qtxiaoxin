<?php

/**
 * This is the model class for table "{{exam}}".
 *
 * The followings are the available columns in table '{{exam}}':
 * @property integer $eid
 * @property string $name
 * @property string $cid
 * @property string $sid
 * @property string $term
 * @property string $userid
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 * @property string $config
 *
 * The followings are the available model relations:
 * @property ExamAloneRelation[] $examAloneRelations
 * @property ExamEvaluation[] $examEvaluations
 */
class Exam extends XiaoXinActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{exam}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, cid, sid, term, userid, schoolid', 'required'),
			array('state, deleted, type, schoolid', 'numerical', 'integerOnly'=>true),
			array('name, term', 'length', 'max'=>50),
			array('cid, sid', 'length', 'max'=>100),
			array('userid, schoolid', 'length', 'max'=>20),
			array('updatetime, config, creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('eid, name, cid, sid, term, userid, state, creationtime, updatetime, deleted, config', 'safe', 'on'=>'search'),
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
			'examAloneRelations' => array(self::HAS_MANY, 'ExamAloneRelation', 'eid'),
			'examEvaluations' => array(self::HAS_MANY, 'ExamEvaluation', 'eid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'eid' => 'Eid',
			'name' => 'Name',
			'cid' => 'Cid',
			'sid' => 'Sid',
			'term' => 'Term',
			'userid' => 'Userid',
			'type' => 'Type',
			'state' => 'State',
			'schoolid' => 'Schoolid',
			'creationtime' => 'Creationtime',
			'updatetime' => 'Updatetime',
			'deleted' => 'Deleted',
			'config' => 'Config',
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

		$criteria->compare('eid',$this->eid);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('cid',$this->cid,true);
		$criteria->compare('sid',$this->sid,true);
		$criteria->compare('term',$this->term,true);
		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('config',$this->config,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
     * 考试列表分页数据
     * panrj,lvxj 2014-09-30
     * @param array $parms 查询条件及分页参数
     * @return array $result
     */
    public function pageData($parms=array(),$sids,$userid)
    {
        $result = array();
        $criteria = new CDbCriteria();
        if(isset($parms['name']) && $parms['name']!=''){
            $criteria->compare('name',$parms['name'],true);
        }
        
        if(isset($parms['sid']) && $parms['sid']!=''){
            $criteria->compare('schoolid',$parms['sid']);
        }else{
            if(count($sids)>0){
                $criteria->addCondition("schoolid in(".implode(",",$sids).")");
            }else{
                $criteria->addCondition("schoolid in(0)");
            }

        }
        if(isset($parms['type']) && $parms['type']!=''){
            $criteria->compare('type',$parms['type']);
        }

        if(isset($parms['cid']) && $parms['cid']!=''){
            $criteria->addCondition('FIND_IN_SET('.$parms['cid'].',cid)');
        }
        if(isset($parms['subject']) && $parms['subject']!=''){
            $criteria->addCondition('FIND_IN_SET('.$parms['subject'].',sid)');
        }
        if(isset($userid) && $userid!=''){
            $criteria->addCondition('FIND_IN_SET('.$userid.',userid)');
        }
        $criteria->compare('deleted',0);
        $criteria->order = 'creationtime DESC';
        $count = self::model()->count ($criteria);
        $pager = new CPagination($count);
        if(isset($parms['size']) && $parms['size']){
            $pager->pageSize = $parms['size'];
        }else{
            $pager->pageSize = 15;
        }
        $pager->applyLimit($criteria);
        $datalist = self::model()->findAll($criteria);
        $result['model'] = $datalist;
        $result['pages'] = $pager;

        return $result;
    }
    
    //考试类型
	public static function getExamType()
	{
		return array('1'=>'单元考试','2'=>'月考','3'=>'期中考试','4'=>'期末考试');
	}

	public function getExamTypeName()
	{
		$arr = self::getExamType();
		if(isset($arr[$this->type])){
			return $arr[$this->type];
		}else{
			return '';
		}
	}

	public function getExamClassName()
	{
		$cids = explode(',',$this->cid);
		$criteria = new CDbCriteria();
		$criteria->compare('cid',$cids);
		$criteria->compare('deleted',0);
		$classes = MClass::model()->findAll($criteria);
		$names = array();
		foreach($classes as $c){
			$names[] = $c->name;
		}
		return implode(",",$names);
	}

    public static function getExamByEid($eid)
    {
        return NoticeQuery::queryRow("select * from tb_exam   where  eid=$eid and deleted=0 ");
    }

	public function getExamsubjectName()
	{
		$cids = explode(',',$this->sid);
		$criteria = new CDbCriteria();
		$criteria->compare('sid',$cids);
		$criteria->compare('deleted',0);
		$subjects = Subject::model()->findAll($criteria);
		$names = array();
		foreach($subjects as $s){
			$names[] = $s->name;
		}
		return implode(",",$names);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Exam the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
