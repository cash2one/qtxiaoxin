<?php

/**
 * This is the model class for table "{{sendpwd}}".
 *
 * The followings are the available columns in table '{{sendpwd}}':
 * @property integer $id
 * @property integer $userid
 * @property integer $sendpwdnum
 * @property integer $maxsendnum
 */
class Sendpwd extends MemberActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{sendpwd}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userid, sendpwdnum, maxsendnum', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, userid, sendpwdnum, maxsendnum', 'safe', 'on'=>'search'),
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
			'id' => 'id',
			'userid' => '老师id',
			'sendpwdnum' => '重发密码次数，',
			'maxsendnum' => '最大发送次数',
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
		$criteria->compare('userid',$this->userid);
		$criteria->compare('sendpwdnum',$this->sendpwdnum);
		$criteria->compare('maxsendnum',$this->maxsendnum);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Sendpwd the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    public static function getTeacherSendpwd($userid){
        $criteria=new CDbCriteria;
        $criteria->compare('userid',$userid);
        return self::model()->find($criteria);
    }
    public static function addTeacherSendpwd($userid,$num){
        $isexists=self::getTeacherSendpwd($userid);
        if(!$isexists){
            $sendpwd=new Sendpwd();
            $sendpwd->userid=$userid;
            $sendpwd->sendpwdnum=$num;
            $sendpwd->save();
            return true;
        }
        return false;
    }

}
