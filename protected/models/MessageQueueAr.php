<?php

/**
 * This is the model class for table "message_queue".
 *
 * The followings are the available columns in table 'message_queue':
 * @property integer $id
 * @property string $user_id
 * @property string $content
 * @property string $time_create
 * @property string $time_update
 * @property integer $status
 */
class MessageQueueAr extends CActiveRecord
{
	
	const STATUS_TO_SEND = 0;
	const STATUS_SUCESS = 1;
	const STATUS_FAULT = -1;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MessageQueueAr the static model class
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
		return 'message_queue';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, content', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>32),
			array('content', 'length', 'max'=>250),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, content, time_create, time_update, status', 'safe', 'on'=>'search'),

			// auto record the time on creating
			array('time_create', 'default', 'value'=>new CDbExpression('NOW()'),
				'setOnEmpty'=>false, 'on'=>'insert'),
			// auto record the time on updating
			array('time_update', 'default', 'value'=>new CDbExpression('NOW()'),
				'setOnEmpty'=>false, 'on'=>array('update','insert')),
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
			'user'	=> array(self::BELONGS_TO, 'UserAr', 'use_id') 
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
			'content' => 'Content',
			'time_create' => 'Time Create',
			'time_update' => 'Time Update',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('time_create',$this->time_create,true);
		$criteria->compare('time_update',$this->time_update,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}