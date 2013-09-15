<?php

/**
 * This is the model class for table "trade".
 *
 * The followings are the available columns in table 'trade':
 * @property string $id
 * @property string $source
 * @property string $source_uid
 * @property double $price
 * @property integer $amount
 * @property string $stock_code
 * @property string $stock_name
 * @property integer $sell_buy
 * @property string $time_deal
 * @property string $remark
 * @property string $note_content
 * @property string $name
 * @property string $st
 * @property string $sd
 * @property string $time_create
 * @property string $time_update
 * @property integer $status
 */
class TradeAr extends CActiveRecord
{

	const ACTION_BUY = 0;
	const ACTION_SELL = 1;
	const STATUS_0 = 0;
	const STATUS_1 = 1;
	const SOURCE_SINA = 'sina';

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TradeAr the static model class
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
		return 'trade';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('source, source_uid, price, amount, stock_code, stock_name, sell_buy, time_deal, name', 'required'),
			array('amount, sell_buy, status', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('source, stock_code, stock_name, name', 'length', 'max'=>20),
			array('source_uid', 'length', 'max'=>32),
			array('remark, note_content', 'length', 'max'=>200),
			array('st, sd', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, source, source_uid, price, amount, stock_code, stock_name, sell_buy, time_deal, remark, note_content, name, st, sd, time_create, time_update, status', 'safe', 'on'=>'search'),
			
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
			'price' => 'Price',
			'amount' => 'Amount',
			'stock_code' => 'Stock Code',
			'stock_name' => 'Stock Name',
			'sell_buy' => 'Sell Buy',
			'time_deal' => 'Time Deal',
			'remark' => 'Remark',
			'note_content' => 'Note Content',
			'name' => 'Name',
			'st' => 'St',
			'sd' => 'Sd',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('source',$this->source,true);
		$criteria->compare('source_uid',$this->source_uid,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('stock_code',$this->stock_code,true);
		$criteria->compare('stock_name',$this->stock_name,true);
		$criteria->compare('sell_buy',$this->sell_buy);
		$criteria->compare('time_deal',$this->time_deal,true);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('note_content',$this->note_content,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('st',$this->st,true);
		$criteria->compare('sd',$this->sd,true);
		$criteria->compare('time_create',$this->time_create,true);
		$criteria->compare('time_update',$this->time_update,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	// public function behaviors(){
	// 	return array(
	// 		'CTimestampBehavior' => array(
	// 			'class' => 'zii.behaviors.CTimestampBehavior',
	// 			'createAttribute' => 'time_create',
	// 			'updateAttribute' => 'time_update',
	// 			'timestampExpression'	=> new CDbExpression('NOW()'),
	// 			'setUpdateOnCreate'	=> true,
	// 		)
	// 	);
	// }
}