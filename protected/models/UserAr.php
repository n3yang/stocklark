<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $name
 * @property string $wechat_open_id
 * @property string $wechat_fake_id
 * @property integer $wechat_followed
 * @property integer $gender
 * @property integer $status
 * @property string $time_create
 * @property string $time_update
 */
class UserAr extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserAr the static model class
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('time_create, time_update', 'required'),
			array('wechat_followed, gender, status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('wechat_open_id, wechat_fake_id', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, wechat_open_id, wechat_fake_id, wechat_followed, gender, status, time_create, time_update', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'wechat_open_id' => 'Wechat Open',
			'wechat_fake_id' => 'Wechat Fake',
			'wechat_followed' => 'Wechat Followed',
			'gender' => 'Gender',
			'status' => 'Status',
			'time_create' => 'Time Create',
			'time_update' => 'Time Update',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('wechat_open_id',$this->wechat_open_id,true);
		$criteria->compare('wechat_fake_id',$this->wechat_fake_id,true);
		$criteria->compare('wechat_followed',$this->wechat_followed);
		$criteria->compare('gender',$this->gender);
		$criteria->compare('status',$this->status);
		$criteria->compare('time_create',$this->time_create,true);
		$criteria->compare('time_update',$this->time_update,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}