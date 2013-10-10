<?php

class SpiderSinaCommand extends CConsoleCommand {

	/**
	 * get the trading log: catch and save
	 * @return bool true/false
	 */
	public function actionUpdateTrade($date='')
	{
		$playerTop20 = array('3546860260','1026334481','3094491385','3441583060','3536839744','1721520531','1891026372','1829196092','2476909985','2119849815','1877585645','1401915280','2906323025','2314717320','1794744725','3093248681','1149275663','2092007254','2432816834','1898457913');
		// $playerTop20 = array('3546860260','1026334481');
		$spider = new SpiderSina;
		$trades['data'] = array();
		foreach ($playerTop20 as $key => $value) {
			$result = $spider->getTradeByUid($value, 3);
			$trades['data'] = array_merge($trades['data'],$result['data']);
		}
		// var_dump($trades);
		/*
		$date = empty($date) ? date('Y-m-d') : $date;
		$spider = new SpiderSina;
		$trades = $spider->getTrade($date);
		*/
		if (!$trades) {
			Yii::log('fault to get sina trade', 'error');
			echo 'fault';
			return false;
		} else {
			// 获取最后更新的交易时间
			$criteria = array(
				'condition'	=> 'source=:source',
				'params'	=> array(':source'=>'sina'),
				'order'		=> 'time_deal DESC'
			);
			$lastDealTime = TradeAr::model()->find($criteria)->getAttribute('time_deal');
			$ds = array();
			foreach ($trades['data'] as $trade) {
				if (strtotime($trade['DealTime']) > strtotime($lastDealTime)) {
					$ds[] = $trade;
					$dsDealTime[] = $trade['DealTime'];
				}
			}
			// update database
			if (!empty($ds)){
				// sort by deal time ASC
				array_multisort($dsDealTime, SORT_ASC, $ds);
				foreach ($ds as $d) {
					$oTrade = new TradeAr;
					$oTrade->source = 'sina';
	  				$oTrade->source_uid = $d['sid'];
					$oTrade->price = empty($d['price']) ? $d['DealPrice'] : $d['price'];
					$oTrade->amount = empty($d['count']) ? $d['DealAmount'] : $d['count'];
					$oTrade->stock_code = $d['StockCode'];
					$oTrade->stock_name = $d['StockName'];
					$oTrade->sell_buy = $d['SellBuy']; // 0买；1卖
					$oTrade->time_deal = $d['DealTime'];
					$oTrade->remark = $d['remark']; // 
					if (empty($d['name'])) {
						$criteria = array(
							'condition'	=> 'source=:source AND source_uid=:source_uid',
							'params'	=> array(':source'=>'sina', ':source_uid'=>$d['sid']),
						);
						$oPlayer = PlayerAr::model()->find($criteria);
						$oTrade->name = $oPlayer->name;
						$oTrade->st = $oPlayer->st; // 
						$oTrade->sd = $oPlayer->sd; //

					} else {
						$oTrade->name = $d['name']; //
						$oTrade->st = $d['qs_name']; // 
						$oTrade->sd = $d['yingyebu']; //
					}
					$rs = $oTrade->save();
					if (!$rs) {
						Yii::log('fault to db insert:'.var_export($oTrade->getErrors(),1), 'error');
					}
				} // end foreach
			}
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
	public function actionUpdatePlayer($num=10000)
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
					if (!$oPlayer) {
						$oPlayer = new PlayerAr;
					}
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
						Yii::log('fault to insert:'.var_export($oPlayer->getErrors(), 1), 'error');
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
					$content = '【新浪投顾大赛】'.$oTrade->name
						.date(' 于m月d日 H:i', strtotime($oTrade->time_deal))
						.' 以'.$oTrade->price.'元 '
						.$sAction.$oTrade->amount.'股 '.$oTrade->stock_name.'（'.$oTrade->stock_code.'）';
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
			$oTrade->status = 1;
			$oTrade->save();
		}


	}
	
	
	public function actionUpdateSubscribe() {
		if ($this->actionUpdateTrade()) {
			$this->actionParseSubscribe();
		}
		return 1;
	}


}