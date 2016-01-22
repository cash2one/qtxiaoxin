<?php

/**
 * This is the model class for table "{{client_version}}".
 *
 * The followings are the available columns in table '{{client_version}}':
 * @property integer $vid
 * @property string $version
 * @property string $size
 * @property string $remark
 * @property string $url
 * @property integer $need
 * @property integer $type
 * @property string $imgs
 * @property integer $deleted
 * @property string $creationtime
 * @property string $updatetime
 */
class ClientVersion extends XiaoXinActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{client_version}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('creationtime', 'required'),
			array('need, type, deleted', 'numerical', 'integerOnly'=>true),
			array('version', 'length', 'max'=>5),
			array('size', 'length', 'max'=>11),
			array('remark', 'length', 'max'=>100),
			array('url', 'length', 'max'=>50),
			array('imgs', 'length', 'max'=>500),
			array('updatetime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('vid, version, size, remark, url, need, type, imgs, deleted, creationtime, updatetime', 'safe', 'on'=>'search'),
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
			'vid' => 'Vid',
			'version' => 'Version',
			'size' => 'Size',
			'remark' => 'Remark',
			'url' => 'Url',
			'need' => 'Need',
			'type' => 'Type',
			'imgs' => 'Imgs',
			'deleted' => 'Deleted',
			'creationtime' => 'Creationtime',
			'updatetime' => 'Updatetime',
		);
	}

	/**
     * 客户端版本升级
     * zengp 2014-12-02
     * @param string $type android,apple
     * @param string $cv client version
     * @return object 
     */
	public static function getVersion($type)
	{
		$criteria = new CDbCriteria;
		$criteria->compare('deleted',0);
		$criteria->compare('type',$type);
		$criteria->order = 'vid DESC';
		$version = self::model()->find($criteria);

		return $version;
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

		$criteria->compare('vid',$this->vid);
		$criteria->compare('version',$this->version,true);
		$criteria->compare('size',$this->size,true);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('need',$this->need);
		$criteria->compare('type',$this->type);
		$criteria->compare('imgs',$this->imgs,true);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ClientVersion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
