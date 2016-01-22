<?php

/**
 * This is the model class for table "{{school}}".
 *
 * The followings are the available columns in table '{{school}}':
 * @property integer $sid
 * @property string $name
 * @property integer $aid
 * @property string $stid
 * @property double $longitude
 * @property double $latitude
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property Class[] $classes
 * @property Area $a
 * @property SchoolTeacherRelation[] $schoolTeacherRelations
 */
class MSchool extends MemberActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{school}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, aid, stid, creationtime', 'required'),
			array('aid, state, deleted', 'numerical', 'integerOnly'=>true),
			array('longitude, latitude', 'numerical'),
			array('name', 'length', 'max'=>20),
			array('stid', 'length', 'max'=>50),
			array('updatetime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('sid, name, aid, stid, longitude, latitude, state, creationtime, updatetime, deleted', 'safe', 'on'=>'search'),
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
			'classes' => array(self::HAS_MANY, 'Class', 'sid'),
			'a' => array(self::BELONGS_TO, 'Area', 'aid'),
			'schoolTeacherRelations' => array(self::HAS_MANY, 'SchoolTeacherRelation', 'sid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sid' => '学校ID',
			'name' => '学校名称',
			'aid' => '地区',
			'stid' => '学校类型：逗号分隔的字符串；如：1,2,3',
			'longitude' => '经度',
			'latitude' => '纬度',
			'state' => '状态：保留字段',
			'creationtime' => '创建时间',
			'updatetime' => '更新时间',
			'deleted' => '已删除',
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

		$criteria->compare('sid',$this->sid);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('aid',$this->aid);
		$criteria->compare('stid',$this->stid,true);
		$criteria->compare('longitude',$this->longitude);
		$criteria->compare('latitude',$this->latitude);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * 返回学校键值数组
	 * panrj 2014-07-25
	 * @return array $arr 
	 */
	public static function getDataArr()
	{
		$criteria = new CDbCriteria();
		$criteria->compare('deleted',0);
		$criteria->order = 'name';
		$data = self::model()->findAll($criteria);
		$arr = array();
		foreach($data as $d){
			$arr[$d->sid] = $d->name;
		}
		return $arr;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MSchool the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
