<?php

/**
 * This is the model class for table "{{sign}}".
 *
 * The followings are the available columns in table '{{sign}}':
 * @property integer $id
 * @property string $userid
 * @property integer $name
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 */
class Sign extends XiaoXinActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{sign}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('state, deleted', 'numerical', 'integerOnly'=>true),
			array('userid', 'length', 'max'=>20),
			array('updatetime,creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, userid, name, state, creationtime, updatetime, deleted', 'safe', 'on'=>'search'),
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
			'userid' => '用户id',
			'name' => '签名',
			'state' => '状态：暂未使用',
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
		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('name',$this->name);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Sign the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    /*
     * 获取用户签名
     */
    public static function getUserSign($userid){
        $criteria=new CDbCriteria;
        $criteria->compare('userid',$userid);
        $criteria->compare('deleted',0);
        return self::model()->findAll($criteria);
    }
    /*
  * 获取用户签名,返回数组
  */
    public static function getUserSignArr($userid){
        $member=Member::model()->findByPk($userid);
        $data=self::getUserSign($userid);
        $arr=array();
        $arr[]=$member->name;
        $arr[]=$member->name.'老师';
        $xing=MainHelper::getXing($member->name);
        if(!empty($xing)){
            $arr[]=$xing.'老师';
        }
        foreach($data as $val){
            $arr[]=$val->name;
        }
        return $arr;
    }

    public static function showSigh($userid){
        $data=self::getUserSign($userid);
        $str="";
        foreach($data as $val){
            $str.="<option value='".$val."'>".$val."<option>";
        }
        return $str;
    }
}
