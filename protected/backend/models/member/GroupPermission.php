<?php

/**
 * This is the model class for table "{{group_permission}}".
 *
 * The followings are the available columns in table '{{group_permission}}':
 * @property integer $id
 * @property string $gid
 * @property string $userid
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 */
class GroupPermission extends MemberActiveRecord
{
    private  $gname;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{group_permission}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gid,userid,createor,createname ', 'required'),
			array('state, deleted', 'numerical', 'integerOnly'=>true),
			array('gid, userid', 'length', 'max'=>11),
			array('updatetime,creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, gid, userid, state, creationtime, updatetime,createor, deleted', 'safe', 'on'=>'search'),
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
            'g' => array(self::BELONGS_TO, 'Group', 'gid'),
            'member0' => array(self::BELONGS_TO, 'Member', 'userid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'gid' => '分组ID',
			'userid' => '能查看组的用户id',
			'state' => '暂未使用',
			'creationtime' => '创建时间',
			'updatetime' => '更新时间',
			'deleted' => '是否已删除',
			'createor' => '创建者id',
			'createname' => '创建者姓名',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('gid',$this->gid,true);
		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    /*
     * 查看某个分组指定的访问人
     */
    public static function getGidShareUsers($gid){
        $criteria=new CDbCriteria();
        $criteria->with=array("member0");
       // $criteria->select="t.userid,name";
        $criteria->compare("t.gid",$gid);
        $criteria->compare("t.deleted",0);
        $criteria->compare("member0.deleted",0);
        return self::model()->findAll($criteria);
    }

    /*
    * 查看某个分组指定的访问人id及名字数组
    */
    public static function getGidShareUserArr($gid){
        $data= self::getGidShareUsers($gid);
        $arr=array();
        foreach($data as $val){
            $arr[]=array('member'=>$val->userid,'name'=>$val->member0?$val->member0->name:'');
        }
        return $arr;
    }

    /*
    * 查看别人指定给他的分组,加上分组类型
     * type=-1表示返回所有
     * type=0表示返回学生的分组
     * type=1表示返回老师分组
    */
    public static function getShareGids($userid,$sid=0,$type=-1){
        $criteria=new CDbCriteria();
        $criteria->with=array("g");
       // $criteria->select="t.gid,g.`name` as gname";
        $criteria->compare("t.userid",$userid);
        $criteria->compare("t.deleted",0);
        $criteria->compare("g.deleted",0);
        if($sid){
            $criteria->compare("g.sid",$sid);
        }
        if($type>=0){
            $criteria->compare("g.type",$type);
        }
        return self::model()->findAll($criteria);
    }
    /*
    * 查看别人指定给他的分组数组
    */
    public static function getShareGidsArr($userid,$sid=0,$type=-1){
        $data=self::getShareGids($userid,$sid,$type);
        $arr=array();
        foreach($data as $val){
            $arr[]=array('gid'=>$val->gid,'name'=>$val->g?$val->g->name:'');
        }
        return $arr;
    }

    /*
     * 删除某个组的访问人
     */
    public static function deletePermissionByGid($gid,$uid=-1){
        $criteria=new CDbCriteria();
        $criteria->compare("gid",$gid);
        if($uid!=-1){
            $criteria->compare("userid",$uid);
        }
        return self::model()->updateAll(array('deleted'=>1),$criteria);
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GroupPermission the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
