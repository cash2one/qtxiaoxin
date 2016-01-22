<?php

/**
 * This is the model class for table "{{user_access}}".
 *
 * The followings are the available columns in table '{{user_access}}':
 * @property integer $id
 * @property integer $uid
 * @property integer $type
 * @property integer $tid
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 */
class UserAccess extends MasterActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user_access}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid, type, tid, deleted', 'required'),
			array('uid, type, tid, state, deleted', 'numerical', 'integerOnly'=>true),
			array('updatetime, creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, uid, type, tid, state, creationtime, updatetime, deleted', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'uid' => '用户ID',
			'type' => '目标类型。1：机构，2：商户',
			'tid' => '目标ID',
			'state' => '状态（暂不启用）',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('type',$this->type);
		$criteria->compare('tid',$this->tid);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * 验证账号是否有学校管理权限
	 * panrj 2014-11-13
	 * @param int $uid 用户ID
	 * @param int $sid 学校ID
	 */
	public static function checkUserSchool($uid,$sid,$type=1)
	{
		$user = User::model()->findByPk($uid);
		if(!$user){
			return false;
		}
		$criteria = new CDbCriteria();
    	$criteria->compare('tid',$sid); 
    	$criteria->compare('uid',$uid); 
    	$criteria->compare('type',$type);
    	$criteria->compare('deleted',0);
        $count = self::model()->count($criteria);
        return $count;
	}

	/**
	 * 返回用户管理的目标id
	 * panrj 2014-11-13
	 * @param int $uid 用户ID
	 * @param int $type 类型
	 */
	public static function getUserAccessTargetPks($uid,$type=1)
	{
		$criteria = new CDbCriteria();
    	$criteria->compare('uid',$uid); 
    	$criteria->compare('type',$type);
    	$criteria->compare('deleted',0);
        $data = self::model()->findAll($criteria);
        $pks = array();
        foreach($data as $d){
        	$pks[] = $d->tid;
        }
        return $pks;
	}

	/**
	 * 删除用户学校管理权限
	 * panrj 2014-11-13
	 * @param int $uid 用户ID
	 * @param int $sid 学校ID
	 */
	public static function deleteUserSchool($uid,$type)
	{
		$criteria = new CDbCriteria();
    	$criteria->compare('uid',$uid); 
    	$criteria->compare('type',$type);
        self::model()->updateAll(array('deleted'=>1),$criteria);
	}

	/**
	 * 添加用户学校管理权限
	 * panrj 2014-11-13
	 * @param int $uid 用户ID
	 * @param int $sid 学校ID
	 */
	public static function saveUserSchool($uid,$sid,$type)
	{
		self::deleteUserSchool($uid,$type);
		foreach($sid as $s){
			$access = new UserAccess;
			$access->type=$type;
			$access->uid=$uid;
			$access->tid=$s;
			$access->save();
		}
	}

	/**
	 * 返回用户管理权限内的学校列表
	 * panrj 2014-11-13
	 * @param int $uid 用户ID
	 * @param bool $showPinYin 是否显示拼音首字母
	 */
	public static function getUserSchools($uid,$showPinYin=true)
	{

		$user = User::model()->findByPk($uid);
		if(!$user){
			return array();
		}
        $mem=UCQuery::getMemcache();
        if(!$mem){
            $mem=Yii::app()->cache;
        }
		if($user->type==0){
            $schools=$mem->get(Constant::CACHE_SCHOOL_LIST);
            if(empty($schools)){
                $criteria = new CDbCriteria;
                $criteria->compare('deleted',0);
                $criteria->order="pingyin";
                $schools = School::model()->findAll($criteria);
                $mem->set(Constant::CACHE_SCHOOL_LIST,$schools);
            }

		}
		if(in_array($user->type,array(1,3))){
            $schools= $mem->get(Constant::CACHE_SCHOOL_LIST.$user->type);
            if($schools==false){
                $sids = self::getUserAccessTargetPks($uid,$type=1);
                $criteria = new CDbCriteria;
                $criteria->compare('deleted',0);
                if(!empty($sids)){
                    $criteria->compare('sid',$sids);
                }
                $criteria->order="pingyin";
                $schools = School::model()->findAll($criteria);
                $mem->set(Constant::CACHE_SCHOOL_LIST.$user->type,$schools);
            }

		}
		if(!count($schools)){
			return array();
		}
		$arr = array();
		foreach($schools as $school){
			$createtype = $school->createtype==1?":（自建）":"";
			$arr[$school->sid] = $showPinYin?strtoupper(substr($school->pingyin,0,1)).':'.$school->name.$createtype:$school->name.$createtype;
		}
		return $arr;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserAccess the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
