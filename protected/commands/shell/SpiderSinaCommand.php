<?php

class SpiderSinaCommand extends CConsoleCommand {

	public function __construct()
	{
		
	}

	/**
	 * get the trading log: catch and save
	 * @return bool true/false
	 */
	public function actionUpdateTrade()
	{
		$spider = new SpiderSina;
		$trades = $spider->getTrade('2013-09-09');
		if (!$trades) {
			Yii::log('fault to get sina players', 'error');
			echo 'fault';
			return false;
		} else {
			// 获取最后更新的交易时间
			$criteria = array(
				'condition'	=> 'source=:source',
				'params'	=> array(':source'=>'sina'),
				'order'		=> 'time_deal DESC'
			);
			$oTrade = TradeAr::model()->find($criteria);
			$lastDealTime = strtotime($oTrade->time_deal);
			foreach ($trades['data'] as $trade) {
				if (strtotime($trade['DealTime']) > $lastDealTime) {
					$ds[] = $trade;
				}
			}
			// order by deal time
			for ($i=count($ds)-1; $i >=0; --$i) { 
				$oTrade = new TradeAr;
				$oTrade->source = 'sina';
  				$oTrade->source_uid = $ds[$i]['sid'];
				$oTrade->price = $ds[$i]['price']; 
				$oTrade->amount = $ds[$i]['count'];
				$oTrade->stock_code = $ds[$i]['StockCode'];
				$oTrade->stock_name = $ds[$i]['StockName'];
				$oTrade->sell_buy = $ds[$i]['SellBuy']; // 0买；1卖
				$oTrade->time_deal = $ds[$i]['DealTime'];
				$oTrade->remark = $ds[$i]['remark']; // 
				$oTrade->name = $ds[$i]['name']; //
				$oTrade->st = $ds[$i]['qs_name']; // 
				$oTrade->sd = $ds[$i]['yingyebu']; //
				$rs = $oTrade->save();
				if (!$rs) {
					Yii::log('fault to db insert:'.var_export($oTrade->getErrors(),1), 'error');
				}
			} // end for
			echo 'done!';
			return true;
		}
	}
	

	/**
	 * udpate player infomations：catch and save
	 * 
	 * @param  integer $num 数量
	 * @return bool    	true/false
	 */
	public function actionUpdatePlayer($num=10)
	{
		$spider = new SpiderSina();
		$players = $spider->getPlayer($num);
		if (!$players){
			Yii::log('fault to get sina players', 'error');
			echo 'fault';
			return false;
		} else {
			foreach ($players['data'] as $player) {
				if ($player){
					$criteria = array(
						'condition'	=> 'source_uid=:source_uid AND source=:source',
						'params'	=> array(':source_uid'=>$player['sid'], ':source'=>'sina'),
					);
					$oPlayer = PlayerAr::model()->find($criteria);
					$oPlayer->source_uid = $player['sid'];
					$oPlayer->name = $player['user_info']['xingming'];
					$oPlayer->st = $player['user_info']['qs_name'];
					$oPlayer->sd = $player['user_info']['yingyebu'];
					$oPlayer->title = $player['user_info']['zhiwei'];
					$oPlayer->intro = $player['user_info']['intr'];
					$oPlayer->certificate = $player['user_info']['zhiyezhenghao'];
					$oPlayer->profit_ratio_d1 = $player['d1_profit_ratio'];
					$oPlayer->profit_ratio_d5 = $player['d5_profit_ratio'];
					$oPlayer->profit_ratio_d20 = $player['d20_profit_ratio'];
					$oPlayer->profit_ratio_total = $player['total_profit_ratio'];
					$rs = $oPlayer->save();
					if (!$rs) {
						Yii::log('fault to insert:'.$oPlayer->getErrors(), 'error');
					}
				}
			} // end foreach
			echo 'done!';
			return true;
		}
	}

	/**
	 * 
	 * @return [type] [description]
	 */
	public function actionParseSubscribe()
	{
		$criteria = array(
			'condition'	=> 'source=:source AND status=0',
			'params'	=> array(':source'=>'sina'),
			'order'		=> 'id ASC',
		);
		$oTrades = TradeAr::model()->findAll($criteria);
		if (!$oTrades) {
			return true;
		}
		foreach ($oTrades as $oTrade) {
			// 
			$term = array(
				'condition'	=> 'time_over>:time_over AND (feature=:stock OR feature=:sina_uid) AND status=1',
				'params'	=> array(
					':time_over'	=> date('Y-m-d H:i:s'),
					':stock'		=> $oTrade->stock_code,
					':sina_uid'		=> $oTrade->source_uid,
					),
				'group'		=> 'user_id',
			);
			$oSubscribes = SubscribeAr::model()->findAll($term);
			foreach ($oSubscribes as $oSubscribe) {
				if ($oSubscribe){
					// 
					$sAction = $oTrade->sell_buy==TradeAr::ACTION_BUY ? '买入' : '卖出';
					$content = $oTrade->name
						.date(' 于m月d日 H:i', strtotime($oTrade->time_deal))
						.' 以'.$oTrade->price.'元 '
						.$sAction.$oTrade->amount.'股 '.$oTrade->stock_name.'('.$oTrade->stock_code.')';
					$user_id = $oSubscribe->user_id;
					// add to message queue
					$oMessageQueue = new MessageQueueAr();
					$oMessageQueue->user_id = $user_id;
					$oMessageQueue->content = $content;
					$oMessageQueue->status = 0;
					$oMessageQueue->save();
				}
			}
			// mark trade to done.
			// $oTrade->status = 1;
			// $oTrade->save();
		}


	}


}