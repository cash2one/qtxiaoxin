<?php

/**
 * This is the model class for table "view_gird_focus".
 *
 * The followings are the available columns in table 'view_gird_focus':
 * @property integer $fid
 * @property string $title
 * @property integer $gbid
 * @property integer $type
 * @property string $bname
 * @property string $gctime
 * @property string $viewcount
 * @property string $joincount
 */
class ViewGirdFocus extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'view_gird_focus';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, type', 'required'),
			array('fid, gbid, type', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>64),
			array('bname', 'length', 'max'=>20),
			array('viewcount, joincount', 'length', 'max'=>21),
			array('gctime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('fid, title, gbid, type, bname, gctime, viewcount, joincount', 'safe', 'on'=>'search'),
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
			'fid' => '热点ID',
			'title' => '标题',
			'gbid' => '商户',
			'type' => '类别：0文章；1问卷',
			'bname' => '商户名称',
			'gctime' => '创建时间',
			'viewcount' => 'Viewcount',
			'joincount' => 'Joincount',
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

		$criteria->compare('fid',$this->fid);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('gbid',$this->gbid);
		$criteria->compare('type',$this->type);
		$criteria->compare('bname',$this->bname,true);
		$criteria->compare('gctime',$this->gctime,true);
		$criteria->compare('viewcount',$this->viewcount,true);
		$criteria->compare('joincount',$this->joincount,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * 热点统计分页数据
	 * panrj 2014-07-17
	 * @param array $parms 查询条件及分页参数
	 * @return array $result 
	 */
	public function pageData($parms=array())
	{
		$result = array();
		$criteria = new CDbCriteria();
		$criteria->select = '`fid`,`title`,`gbid`,`type`,`bname`,`gctime`,`viewcount`,`joincount`';
		if(isset($parms['title']) && $parms['title']!=''){
        	$criteria->compare('title',$parms['title'],true);
        }
        if(isset($parms['type'])){
        	$criteria->compare('type',$parms['type']);
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

	public static function getTypeArr()
	{
		$arr = array(
			'0'=>'新闻',
			'1'=>'问卷',
			'2'=>'链接',
		);
		return $arr;
	}

	public function getTypeName()
	{
		$arr = $this->getTypeArr();
		return $arr[$this->type];
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ViewGirdFocus the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
