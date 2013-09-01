<?php

/**
 * This is the model class for table "player".
 *
 * The followings are the available columns in table 'player':
 * @property integer $id
 * @property string $source
 * @property string $source_uid
 * @property string $name
 * @property string $st
 * @property string $sd
 * @property string $title
 * @property string $intro
 * @property string $certificate
 * @property string $profit_ratio_d1
 * @property string $profit_ratio_d5
 * @property string $profit_ratio_d20
 * @property string $profit_ratio_total
 * @property string $time_create
 * @property string $time_update
 */
class PlayerAr extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PlayerAr the static model class
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
		return 'player';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('source_uid, name, time_create, time_update', 'required'),
			array('source, name, profit_ratio_d1, profit_ratio_d5, profit_ratio_d20, profit_ratio_total', 'length', 'max'=>20),
			array('source_uid', 'length', 'max'=>32),
			array('st, sd', 'length', 'max'=>100),
			array('title, certificate', 'length', 'max'=>50),
			array('intro', 'length', 'max'=>250),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, source, source_uid, name, st, sd, title, intro, certificate, profit_ratio_d1, profit_ratio_d5, profit_ratio_d20, profit_ratio_total, time_create, time_update', 'safe', 'on'=>'search'),
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
			'source' => 'Source',
			'source_uid' => 'Source Uid',
			'name' => 'Name',
			'st' => 'St',
			'sd' => 'Sd',
			'title' => 'Title',
			'intro' => 'Intro',
			'certificate' => 'Certificate',
			'profit_ratio_d1' => 'Profit Ratio D1',
			'profit_ratio_d5' => 'Profit Ratio D5',
			'profit_ratio_d20' => 'Profit Ratio D20',
			'profit_ratio_total' => 'Profit Ratio Total',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('source',$this->source,true);
		$criteria->compare('source_uid',$this->source_uid,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('st',$this->st,true);
		$criteria->compare('sd',$this->sd,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('intro',$this->intro,true);
		$criteria->compare('certificate',$this->certificate,true);
		$criteria->compare('profit_ratio_d1',$this->profit_ratio_d1,true);
		$criteria->compare('profit_ratio_d5',$this->profit_ratio_d5,true);
		$criteria->compare('profit_ratio_d20',$this->profit_ratio_d20,true);
		$criteria->compare('profit_ratio_total',$this->profit_ratio_total,true);
		$criteria->compare('time_create',$this->time_create,true);
		$criteria->compare('time_update',$this->time_update,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}