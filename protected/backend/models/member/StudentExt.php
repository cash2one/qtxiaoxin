<?php

/**
 * This is the model class for table "{{student_ext}}".
 *
 * The followings are the available columns in table '{{student_ext}}':
 * @property string $userid
 * @property string $studentid
 * @property integer $entertime
 * @property string $activatedate
 * @property string $Address
 * @property string $Info
 * @property integer $sid
 *
 * The followings are the available model relations:
 * @property User $user
 */
class StudentExt extends MemberActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{student_ext}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userid,studentid', 'required'),
			array('entertime, sid', 'numerical', 'integerOnly'=>true),
			array('userid, studentid', 'length', 'max'=>20),
			array('Address', 'length', 'max'=>256),
			array('activatedate, Info,entertime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('userid, studentid, entertime, activatedate, Address, Info, sid', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'userid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'userid' => '用户编号',
			'studentid' => '学号',
			'entertime' => '入学时间',
			'activatedate' => '激活时间',
			'Address' => '家庭地址',
			'Info' => '个人介绍',
			'sid' => '学校',
            'state' => '状态：0待激活；1已激活',
            'creationtime' => '创建时间',
            'deleted' => '已删除：0未删除；1已删除',
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

		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('studentid',$this->studentid,true);
		$criteria->compare('entertime',$this->entertime);
		$criteria->compare('activatedate',$this->activatedate,true);
		$criteria->compare('Address',$this->Address,true);
		$criteria->compare('Info',$this->Info,true);
		$criteria->compare('sid',$this->sid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
     * 返回学生扩展信息，没有则创建并返回
     * panrj 2014-11-17
     * @param int $sid 学生ID
     */
	public static function getOrCreate($sid)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('userid',$sid);
		$criteria->compare('deleted',0);
		$ext = self::model()->find($criteria);
		if(!$ext){
			$ext = new StudentExt;
			$ext->userid = $sid;
			$ext->save();
		}
		return $ext;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StudentExt the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
