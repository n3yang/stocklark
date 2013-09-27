<?php

/**
 * This is the model class for table "subscribe".
 *
 * The followings are the available columns in table 'subscribe':
 * @property string $id
 * @property integer $user_id
 * @property integer $type
 * @property string $feature
 * @property string $time_create
 * @property string $time_over
 * @property integer $status
 */
class SubscribeAr extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SubscribeAr the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'subscribe';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, time_over', 'required'),
			array('user_id, type, status', 'numerical', 'integerOnly'=>true),
			array('feature', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, type, feature, time_create, time_over, status', 'safe', 'on'=>'search'),
			
			// auto record the time on creating
			array('time_create', 'default', 'value'=>new CDbExpression('NOW()'),
				'setOnEmpty'=>false, 'on'=>'insert'),
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
			'user'	=> array(self::BELONGS_TO, 'UserAr', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'type' => 'Type',
			'feature' => 'Feature',
			'time_create' => 'Time Create',
			'time_over' => 'Time Over',
			'status' => 'Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('type',$this->type);
		$criteria->compare('feature',$this->feature,true);
		$criteria->compare('time_create',$this->time_create,true);
		$criteria->compare('time_over',$this->time_over,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}