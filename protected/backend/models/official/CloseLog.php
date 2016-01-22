<?php

/**
 * This is the model class for table "{{close_log}}".
 *
 * The followings are the available columns in table '{{close_log}}':
 * @property string $closeid
 * @property string $msgid
 * @property integer $close
 * @property string $reason
 * @property string $creationtime
 */
class CloseLog extends OfficialActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{close_log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('msgid, close, reason', 'required'),
			array('close', 'numerical', 'integerOnly'=>true),
			array('msgid', 'length', 'max'=>10),
			array('reason', 'length', 'max'=>600),
			array('creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('closeid, msgid, close, reason, creationtime', 'safe', 'on'=>'search'),
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
			'closeid' => 'Closeid',
			'msgid' => 'Msgid',
			'close' => 'Close',
			'reason' => 'Reason',
			'creationtime' => 'Creationtime',
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

		$criteria->compare('closeid',$this->closeid,true);
		$criteria->compare('msgid',$this->msgid,true);
		$criteria->compare('close',$this->close);
		$criteria->compare('reason',$this->reason,true);
		$criteria->compare('creationtime',$this->creationtime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getLastReason($msgid, $close = 2)
    {
        $sql = 'SELECT reason FROM '.$this->tableName().' WHERE msgid = '.$msgid.' AND close = '.$close.' ORDER BY creationtime DESC LIMIT 1';
        $command = $this->dbConnection->createCommand($sql);
        $row = $command->queryRow();

        return $row;
    }
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CloseLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
