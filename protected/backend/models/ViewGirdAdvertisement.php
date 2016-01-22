<?php

/**
 * This is the model class for table "view_gird_advertisement".
 *
 * The followings are the available columns in table 'view_gird_advertisement':
 * @property integer $aid
 * @property string $title
 * @property integer $abid
 * @property string $bname
 * @property string $gctime
 * @property string $viewcount
 */
class ViewGirdAdvertisement extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'view_gird_advertisement';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('aid, gbid', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>64),
			array('bname', 'length', 'max'=>20),
			array('viewcount', 'length', 'max'=>21),
			array('gctime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('aid, title, abid, bname, gctime, viewcount', 'safe', 'on'=>'search'),
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
			'aid' => '广告ID',
			'title' => '广告标题',
			'gbid' => '商户',
			'bname' => '商户名称',
			'gctime' => '创建时间',
			'viewcount' => 'Viewcount',
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

		$criteria->compare('aid',$this->aid);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('gbid',$this->gbid);
		$criteria->compare('bname',$this->bname,true);
		$criteria->compare('gctime',$this->gctime,true);
		$criteria->compare('viewcount',$this->viewcount,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * 广告统计分页数据
	 * panrj 2014-07-17
	 * @param array $parms 查询条件及分页参数
	 * @return array $result 
	 */
	public function pageData($parms=array())
	{
		$result = array();
		$criteria = new CDbCriteria();
		$criteria->select = '`aid`,`title`,`gbid`,`bname`,`gctime`,`viewcount`';
		if(isset($parms['title']) && $parms['title']!=''){
        	$criteria->compare('title',$parms['title'],true);
        }
        
        if(isset($parms['bid']) && $parms['bid']){
        	$criteria->compare('gbid',$parms['bid']);
        }

        if(isset($parms['contype']) && $parms['contype']){
			if($parms['contype']=='public'){
				$criteria->addCondition('ISNULL(gbid)');
			}else{
				$criteria->addCondition('gbid IS NOT NULL');
			}
		}

		$criteria->order = 'gctime DESC';     
        $count = self::model()->count($criteria); 
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

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ViewGirdAdvertisement the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
